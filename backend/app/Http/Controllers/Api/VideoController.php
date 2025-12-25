<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(20);
        return response()->json($videos);
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return response()->json($video);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|string', // Changed from 'url' to 'string' to allow Google Drive links
            'video_type' => 'nullable|string|in:url,gdrive', // Added validation for video_type
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:512000', // 500MB max
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB max
            'duration' => 'nullable|string',
            'category' => 'nullable|string|max:255',
        ]);

        // Harus ada video_url ATAU video_file
        $hasVideoUrl = $request->has('video_url') && !empty($request->video_url);
        $hasVideoFile = $request->hasFile('video_file');
        
        if (!$hasVideoUrl && !$hasVideoFile) {
            return response()->json([
                'message' => 'Either video_url or video_file is required',
            ], 422);
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['views'] = 0;

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/videos', $filename, 'public');
            
            $validated['video_file_path'] = $path;
            $validated['video_type'] = 'file';
            $validated['video_mime_type'] = $file->getMimeType();
            $validated['video_size'] = $file->getSize();
            $validated['video_url'] = null; // Clear video_url if file is uploaded
        } else {
            // Check if it's Google Drive link
            $videoUrl = $request->input('video_url');
            $isGoogleDrive = $request->has('video_type') && $request->input('video_type') === 'gdrive';
            
            // Auto-detect Google Drive if not explicitly set
            if (!$isGoogleDrive && $videoUrl && (strpos($videoUrl, 'drive.google.com') !== false || strpos($videoUrl, 'docs.google.com') !== false)) {
                $isGoogleDrive = true;
            }
            
            if ($isGoogleDrive) {
                $validated['video_type'] = 'gdrive';
            } else {
                $validated['video_type'] = 'url';
            }
            $validated['video_file_path'] = null;
        }

        // Handle thumbnail file upload
        if ($request->hasFile('thumbnail_file')) {
            $thumbnailFile = $request->file('thumbnail_file');
            $thumbnailFilename = time() . '_thumb_' . Str::random(10) . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailPath = $thumbnailFile->storeAs('media/thumbnails', $thumbnailFilename, 'public');
            
            $apiUrl = env('APP_URL', 'http://localhost:8000');
            $validated['thumbnail'] = $apiUrl . '/storage/' . $thumbnailPath;
        }

        // Remove file inputs from validated array
        unset($validated['video_file'], $validated['thumbnail_file']);

        $video = Video::create($validated);
        
        return response()->json($video, 201);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|string', // Changed from 'url' to 'string' to allow Google Drive links
            'video_type' => 'nullable|string|in:url,gdrive', // Added validation for video_type
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:512000', // 500MB max
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB max
            'duration' => 'nullable|string',
            'category' => 'nullable|string|max:255',
        ]);

        // Handle video update (jika ada perubahan)
        $hasVideoUrl = $request->has('video_url') && !empty($request->video_url);
        $hasVideoFile = $request->hasFile('video_file');
        
        if ($hasVideoFile) {
            // Upload new video file
            // Delete old video file if exists
            if ($video->video_file_path && Storage::disk('public')->exists($video->video_file_path)) {
                Storage::disk('public')->delete($video->video_file_path);
            }

            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/videos', $filename, 'public');
            
            $validated['video_file_path'] = $path;
            $validated['video_type'] = 'file';
            $validated['video_mime_type'] = $file->getMimeType();
            $validated['video_size'] = $file->getSize();
            $validated['video_url'] = null;
        } else if ($hasVideoUrl) {
            // Update to URL (YouTube/Vimeo) or Google Drive
            // Delete old video file if exists
            if ($video->video_file_path && Storage::disk('public')->exists($video->video_file_path)) {
                Storage::disk('public')->delete($video->video_file_path);
            }
            
            // Check if it's Google Drive link
            $videoUrl = $request->input('video_url');
            $isGoogleDrive = $request->has('video_type') && $request->input('video_type') === 'gdrive';
            
            // Auto-detect Google Drive if not explicitly set
            if (!$isGoogleDrive && $videoUrl && (strpos($videoUrl, 'drive.google.com') !== false || strpos($videoUrl, 'docs.google.com') !== false)) {
                $isGoogleDrive = true;
            }
            
            if ($isGoogleDrive) {
                $validated['video_type'] = 'gdrive';
            } else {
                $validated['video_type'] = 'url';
            }
            $validated['video_file_path'] = null;
            $validated['video_mime_type'] = null;
            $validated['video_size'] = null;
        }
        // Jika tidak ada perubahan video, tetap gunakan yang lama (tidak perlu di-set di $validated)

        // Handle thumbnail file upload
        if ($request->hasFile('thumbnail_file')) {
            $thumbnailFile = $request->file('thumbnail_file');
            $thumbnailFilename = time() . '_thumb_' . Str::random(10) . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailPath = $thumbnailFile->storeAs('media/thumbnails', $thumbnailFilename, 'public');
            
            $apiUrl = env('APP_URL', 'http://localhost:8000');
            $validated['thumbnail'] = $apiUrl . '/storage/' . $thumbnailPath;
        }

        // Remove file inputs from validated array
        unset($validated['video_file'], $validated['thumbnail_file']);

        $validated['slug'] = Str::slug($validated['title']);
        
        $video->update($validated);
        
        return response()->json($video);
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        
        // Delete video file if exists
        if ($video->video_file_path && Storage::disk('public')->exists($video->video_file_path)) {
            Storage::disk('public')->delete($video->video_file_path);
        }
        
        // Delete thumbnail file if exists (if it's a file, not URL)
        if ($video->thumbnail && strpos($video->thumbnail, '/storage/') !== false) {
            $thumbnailPath = str_replace(env('APP_URL') . '/storage/', '', $video->thumbnail);
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
        }
        
        $video->delete();
        
        return response()->json(['message' => 'Video deleted successfully']);
    }
}
