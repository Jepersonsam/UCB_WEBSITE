<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use App\Models\Article;
use App\Models\Video;
use App\Models\Event;
use App\Models\Album;
use App\Models\Promosi;

class CleanupMissingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:cleanup-missing {--dry-run : Show what would be cleaned without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membersihkan record di database yang tidak memiliki file fisik di storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('🔍 Mode DRY-RUN: Tidak akan menghapus data, hanya menampilkan data yang akan dibersihkan');
        } else {
            $this->warn('⚠️  Mode DELETE: Akan menghapus data yang tidak memiliki file fisik!');
            if (!$this->confirm('Apakah Anda yakin ingin melanjutkan?')) {
                $this->info('Operasi dibatalkan.');
                return 0;
            }
        }

        $this->newLine();
        $totalDeleted = 0;

        // 1. Cleanup Media table
        $this->info('📸 Membersihkan tabel Media...');
        $mediaCount = $this->cleanupMedia($dryRun);
        $totalDeleted += $mediaCount;
        $this->line("   Ditemukan: {$mediaCount} record tanpa file");

        // 2. Cleanup Articles (featured_image)
        $this->info('📰 Membersihkan featured_image di tabel Articles...');
        $articleCount = $this->cleanupArticles($dryRun);
        $totalDeleted += $articleCount;
        $this->line("   Ditemukan: {$articleCount} artikel dengan featured_image yang hilang");

        // 3. Cleanup Videos (thumbnail dan video_file_path)
        $this->info('🎥 Membersihkan thumbnail dan video files di tabel Videos...');
        $videoCount = $this->cleanupVideos($dryRun);
        $totalDeleted += $videoCount;
        $this->line("   Ditemukan: {$videoCount} video dengan thumbnail atau video file yang hilang");

        // 4. Cleanup Events (featured_image)
        $this->info('📅 Membersihkan featured_image di tabel Events...');
        $eventCount = $this->cleanupEvents($dryRun);
        $totalDeleted += $eventCount;
        $this->line("   Ditemukan: {$eventCount} event dengan featured_image yang hilang");

        // 5. Cleanup Albums (cover_image)
        $this->info('🖼️  Membersihkan cover_image di tabel Albums...');
        $albumCount = $this->cleanupAlbums($dryRun);
        $totalDeleted += $albumCount;
        $this->line("   Ditemukan: {$albumCount} album dengan cover_image yang hilang");

        // 6. Cleanup Promosi (image)
        $this->info('🎯 Membersihkan image di tabel Promosi...');
        $promosiCount = $this->cleanupPromosi($dryRun);
        $totalDeleted += $promosiCount;
        $this->line("   Ditemukan: {$promosiCount} promosi dengan image yang hilang");

        $this->newLine();
        if ($dryRun) {
            $this->info("✅ Total record yang akan dibersihkan: {$totalDeleted}");
            $this->info('💡 Jalankan tanpa --dry-run untuk benar-benar menghapus data');
        } else {
            $this->info("✅ Total record yang dibersihkan: {$totalDeleted}");
        }

        return 0;
    }

    private function cleanupMedia($dryRun)
    {
        $allMedia = Media::where('type', 'image')->get();
        $deletedCount = 0;
        
        foreach ($allMedia as $media) {
            if (!$media->path || !Storage::disk('public')->exists($media->path)) {
                if ($dryRun) {
                    $this->line("   - Media ID {$media->id}: {$media->filename} (path: {$media->path})");
                } else {
                    // Detach from all albums
                    $media->albums()->detach();
                    // Delete media record
                    $media->delete();
                }
                $deletedCount++;
            }
        }
        
        return $deletedCount;
    }

    private function cleanupArticles($dryRun)
    {
        $articles = Article::whereNotNull('featured_image')->get();
        $cleanedCount = 0;
        
        foreach ($articles as $article) {
            // Skip if it's a URL (starts with http:// or https://)
            if (str_starts_with($article->featured_image, 'http://') || 
                str_starts_with($article->featured_image, 'https://')) {
                continue;
            }
            
            if (!Storage::disk('public')->exists($article->featured_image)) {
                if ($dryRun) {
                    $this->line("   - Article ID {$article->id}: {$article->title} (image: {$article->featured_image})");
                } else {
                    $article->featured_image = null;
                    $article->save();
                }
                $cleanedCount++;
            }
        }
        
        return $cleanedCount;
    }

    private function cleanupVideos($dryRun)
    {
        // Get ALL videos to check for missing files
        $videos = Video::all();
        
        $cleanedCount = 0;
        
        foreach ($videos as $video) {
            $hasChanges = false;
            $changes = [];
            
            // Check thumbnail
            if ($video->thumbnail) {
                // Skip if it's a URL (starts with http:// or https://)
                if (!str_starts_with($video->thumbnail, 'http://') && 
                    !str_starts_with($video->thumbnail, 'https://')) {
                    
                    // Extract path from URL if it contains /storage/
                    $path = $video->thumbnail;
                    if (str_contains($path, '/storage/')) {
                        $path = str_replace('/storage/', '', $path);
                    }
                    
                    if (!Storage::disk('public')->exists($path)) {
                        if ($dryRun) {
                            $changes[] = "thumbnail: {$video->thumbnail}";
                        } else {
                            $video->thumbnail = null;
                            $hasChanges = true;
                        }
                    }
                }
            }
            
            // Check video_file_path (cek semua yang punya path, tidak peduli video_type)
            if ($video->video_file_path) {
                if (!Storage::disk('public')->exists($video->video_file_path)) {
                    if ($dryRun) {
                        $changes[] = "video_file_path: {$video->video_file_path} (type: {$video->video_type})";
                    } else {
                        $video->video_file_path = null;
                        // Jika video_type adalah 'file', ubah ke 'url' karena file tidak ada
                        if ($video->video_type === 'file') {
                            $video->video_type = 'url';
                        }
                        $hasChanges = true;
                    }
                }
            }
            
            if (!empty($changes) || $hasChanges) {
                if ($dryRun) {
                    $this->line("   - Video ID {$video->id}: {$video->title} (" . implode(', ', $changes) . ")");
                } else {
                    $video->save();
                }
                $cleanedCount++;
            }
        }
        
        return $cleanedCount;
    }

    private function cleanupEvents($dryRun)
    {
        $events = Event::whereNotNull('featured_image')->get();
        $cleanedCount = 0;
        
        foreach ($events as $event) {
            // Skip if it's a URL (starts with http:// or https://)
            if (str_starts_with($event->featured_image, 'http://') || 
                str_starts_with($event->featured_image, 'https://')) {
                continue;
            }
            
            if (!Storage::disk('public')->exists($event->featured_image)) {
                if ($dryRun) {
                    $this->line("   - Event ID {$event->id}: {$event->title} (image: {$event->featured_image})");
                } else {
                    $event->featured_image = null;
                    $event->save();
                }
                $cleanedCount++;
            }
        }
        
        return $cleanedCount;
    }

    private function cleanupAlbums($dryRun)
    {
        $albums = Album::whereNotNull('cover_image')->get();
        $cleanedCount = 0;
        
        foreach ($albums as $album) {
            // Skip if it's a URL (starts with http:// or https://)
            if (str_starts_with($album->cover_image, 'http://') || 
                str_starts_with($album->cover_image, 'https://')) {
                continue;
            }
            
            if (!Storage::disk('public')->exists($album->cover_image)) {
                if ($dryRun) {
                    $this->line("   - Album ID {$album->id}: {$album->name} (cover: {$album->cover_image})");
                } else {
                    $album->cover_image = null;
                    $album->save();
                }
                $cleanedCount++;
            }
        }
        
        return $cleanedCount;
    }

    private function cleanupPromosi($dryRun)
    {
        $promosi = Promosi::whereNotNull('image')->get();
        $cleanedCount = 0;
        
        foreach ($promosi as $item) {
            // Skip if it's a URL (starts with http:// or https://)
            if (str_starts_with($item->image, 'http://') || 
                str_starts_with($item->image, 'https://')) {
                continue;
            }
            
            if (!Storage::disk('public')->exists($item->image)) {
                if ($dryRun) {
                    $this->line("   - Promosi ID {$item->id}: {$item->title} (image: {$item->image})");
                } else {
                    $item->image = null;
                    $item->save();
                }
                $cleanedCount++;
            }
        }
        
        return $cleanedCount;
    }
}
