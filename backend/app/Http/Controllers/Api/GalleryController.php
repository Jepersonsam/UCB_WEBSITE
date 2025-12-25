<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::with(['media' => function($query) {
            $query->orderBy('album_media.sort_order');
        }])->latest()->get();
        
        return response()->json([
            'albums' => $albums,
            'all_media' => Media::where('type', 'image')->latest()->get(),
        ]);
    }

    public function show($id)
    {
        $album = Album::with(['media' => function($query) {
            $query->orderBy('album_media.sort_order');
        }])->findOrFail($id);
        
        return response()->json($album);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $album = Album::create($validated);
        
        return response()->json($album->load('media'), 201);
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $album->update($validated);
        
        return response()->json($album->load('media'));
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        
        return response()->json(['message' => 'Album deleted successfully']);
    }

    public function upload(Request $request)
    {
        try {
            $validated = $request->validate([
                'file' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:51200', // 50MB max
                'album_id' => 'nullable|exists:albums,id',
                'alt_text' => 'nullable|string|max:255',
                'caption' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        if (!$request->hasFile('file')) {
            return response()->json([
                'message' => 'No file uploaded',
            ], 422);
        }

        $file = $request->file('file');
        
        if (!$file->isValid()) {
            return response()->json([
                'message' => 'Invalid file',
            ], 422);
        }

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('media/images', $filename, 'public');

        // Get image dimensions
        $imageInfo = getimagesize($file->getRealPath());
        $width = $imageInfo[0] ?? null;
        $height = $imageInfo[1] ?? null;

        $media = Media::create([
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'path' => $path,
            'type' => 'image',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'width' => $width,
            'height' => $height,
            'alt_text' => $request->alt_text,
            'caption' => $request->caption,
        ]);

        // Attach to album if provided
        if ($request->album_id) {
            $album = Album::findOrFail($request->album_id);
            $maxOrder = $album->media()->max('album_media.sort_order') ?? 0;
            $album->media()->attach($media->id, ['sort_order' => $maxOrder + 1]);
        }

        return response()->json([
            'message' => 'Image uploaded successfully',
            'media' => $media,
        ], 201);
    }

    public function attachMedia(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        
        $request->validate([
            'media_ids' => 'required|array',
            'media_ids.*' => 'exists:media,id',
        ]);

        $maxOrder = $album->media()->max('album_media.sort_order') ?? 0;
        
        foreach ($request->media_ids as $index => $mediaId) {
            if (!$album->media()->where('media_id', $mediaId)->exists()) {
                $album->media()->attach($mediaId, ['sort_order' => $maxOrder + $index + 1]);
            }
        }

        return response()->json($album->load('media'));
    }

    public function detachMedia(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        
        $request->validate([
            'media_id' => 'required|exists:media,id',
        ]);

        $album->media()->detach($request->media_id);

        return response()->json(['message' => 'Media detached successfully']);
    }

    public function deleteMedia($id)
    {
        $media = Media::findOrFail($id);
        
        // Delete file from storage
        if ($media->path && Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }
        
        // Detach from all albums
        $media->albums()->detach();
        
        // Delete media record
        $media->delete();

        return response()->json(['message' => 'Media deleted successfully']);
    }
}
