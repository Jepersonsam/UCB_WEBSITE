<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('articles')->latest()->get();
        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $tag = Tag::create($validated);
        
        return response()->json($tag, 201);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $tag->update($validated);
        
        return response()->json($tag);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        
        return response()->json(['message' => 'Tag deleted successfully']);
    }
}

