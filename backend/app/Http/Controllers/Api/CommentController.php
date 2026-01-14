<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $articleId = $request->query('article_id');
        
        if ($articleId) {
            // Get comments for specific article (only approved, top-level comments)
            $comments = Comment::where('article_id', $articleId)
                ->whereNull('parent_id')
                ->where('is_approved', true)
                ->with(['replies'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json($comments);
        }
        
        // For admin: get all comments with pagination
        $comments = Comment::with(['article', 'parent'])
            ->latest()
            ->paginate(20);
        
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'parent_id' => 'nullable|exists:comments,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string',
        ]);

        // Check if article exists and is published
        $article = Article::findOrFail($validated['article_id']);
        if ($article->status !== 'published') {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }

        // If parent_id is provided, verify it belongs to the same article
        if (isset($validated['parent_id'])) {
            $parent = Comment::findOrFail($validated['parent_id']);
            if ($parent->article_id !== $validated['article_id']) {
                return response()->json(['message' => 'Komentar parent tidak valid'], 422);
            }
        }

        // New comments are auto-approved
        $validated['is_approved'] = true;
        
        $comment = Comment::create($validated);

        return response()->json([
            'message' => 'Komentar berhasil dikirim',
            'data' => $comment->load('replies'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::with(['article', 'parent', 'replies'])->findOrFail($id);
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);

        $validated = $request->validate([
            'is_approved' => 'sometimes|boolean',
            'comment' => 'sometimes|string',
        ]);

        $comment->update($validated);

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Komentar berhasil dihapus']);
    }
}
