<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return response()->json($pages);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return response()->json($page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page = Page::create($validated);
        
        return response()->json($page, 201);
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $id,
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_published' => 'boolean',
        ]);
        
        $page->update($validated);
        
        return response()->json($page);
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        
        return response()->json(['message' => 'Page deleted successfully']);
    }
}
