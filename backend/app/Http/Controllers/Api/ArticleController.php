<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $data = Article::with(['category', 'tags'])->latest()->paginate(10);
        return response()->json($data);
    }

    public function show($id)
    {
        // Try to find by ID if numeric, otherwise by slug
        if (is_numeric($id)) {
            $article = Article::with(['category', 'tags'])->findOrFail($id);
        } else {
            $article = Article::with(['category', 'tags'])->where('slug', $id)->firstOrFail();
        }
        
        // Only return published articles for public access (non-authenticated users)
        if (!request()->user() && $article->status !== 'published') {
            abort(404);
        }
        
        return response()->json($article);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'featured_image_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB max
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Handle featured image file upload
        if ($request->hasFile('featured_image_file')) {
            $file = $request->file('featured_image_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/articles', $filename, 'public');
            $validated['featured_image'] = $path;
        } elseif ($request->has('featured_image') && $request->featured_image) {
            // Handle featured image from URL or gallery (path)
            $validated['featured_image'] = $request->featured_image;
        }

        // Remove file input from validated array
        unset($validated['featured_image_file']);

        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;
        $article = Article::create($validated);
        if (!empty($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        }
        return response()->json($article->load(['category', 'tags']), 201);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Debug: Log raw request data
        \Log::info('Article Update - Raw Request', [
            'article_id' => $id,
            'all_input' => $request->all(),
            'has_featured_image' => $request->has('featured_image'),
            'featured_image_value' => $request->input('featured_image'),
            'featured_image_raw' => $request->get('featured_image'),
        ]);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $id,
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'featured_image_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB max
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Handle featured image file upload
        if ($request->hasFile('featured_image_file')) {
            // Delete old image if exists
            if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                Storage::disk('public')->delete($article->featured_image);
            }
            
            $file = $request->file('featured_image_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/articles', $filename, 'public');
            $validated['featured_image'] = $path;
        } else {
            // Check for featured_image in request (from FormData)
            // Read directly from all() to ensure we get the value
            $allData = $request->all();
            if (array_key_exists('featured_image', $allData)) {
                $imageValue = $allData['featured_image'];
                // Handle featured image from URL or gallery (path)
                // If empty string, set to null to clear the image
                if ($imageValue === '' || $imageValue === null) {
                    $validated['featured_image'] = null;
                } else {
                    $validated['featured_image'] = $imageValue;
                }
            }
        }

        // Remove file input from validated array
        unset($validated['featured_image_file']);

        // Build update data - always include featured_image if it was sent
        $updateData = [];
        
        // Always include featured_image if it's in validated (means it was sent from frontend)
        // OR if it was explicitly sent in the request (even if empty string)
        if (array_key_exists('featured_image', $validated)) {
            $updateData['featured_image'] = $validated['featured_image'];
            \Log::info('Article Update - Featured image will be updated', [
                'old_value' => $article->featured_image,
                'new_value' => $validated['featured_image'],
            ]);
        } elseif ($request->has('featured_image') || isset($request->all()['featured_image'])) {
            // If featured_image was sent but not in validated, get it directly from request
            $imageValue = $request->input('featured_image') ?? ($request->all()['featured_image'] ?? null);
            $updateData['featured_image'] = ($imageValue === '' || $imageValue === null) ? null : $imageValue;
            \Log::info('Article Update - Featured image from request (not validated)', [
                'old_value' => $article->featured_image,
                'new_value' => $updateData['featured_image'],
            ]);
        }
        
        // Add other fields
        foreach ($validated as $key => $value) {
            if ($key !== 'featured_image' && $value !== null && $value !== '') {
                $updateData[$key] = $value;
            }
        }

        \Log::info('Article Update - Update Data', [
            'update_data' => $updateData,
        ]);

        if (isset($updateData['status']) && $updateData['status'] === 'published' && !$article->published_at) {
            $updateData['published_at'] = now();
        }

        $article->update($updateData);
        
        \Log::info('Article Update - After Update', [
            'article_featured_image' => $article->fresh()->featured_image,
        ]);
        if (isset($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        }
        return response()->json($article->load(['category', 'tags']));
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(['message' => 'deleted']);
    }
}

