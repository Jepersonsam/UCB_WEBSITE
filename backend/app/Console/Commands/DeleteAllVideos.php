<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class DeleteAllVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videos:delete-all {--force : Hapus tanpa konfirmasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus semua video dari database dan file terkait';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $videos = Video::all();
        $totalVideos = $videos->count();

        if ($totalVideos === 0) {
            $this->info('Tidak ada video di database.');
            return 0;
        }

        $this->warn("⚠️  PERINGATAN: Akan menghapus {$totalVideos} video dari database!");
        $this->line('Ini akan menghapus:');
        $this->line('  - Semua record video di database');
        $this->line('  - File video yang tersimpan (jika ada)');
        $this->line('  - File thumbnail yang tersimpan (jika ada)');
        $this->newLine();

        if (!$this->option('force')) {
            if (!$this->confirm('Apakah Anda yakin ingin melanjutkan?', false)) {
                $this->info('Operasi dibatalkan.');
                return 0;
            }
        }

        $this->info('Menghapus video...');
        $deletedCount = 0;
        $fileDeletedCount = 0;
        $thumbnailDeletedCount = 0;

        $bar = $this->output->createProgressBar($totalVideos);
        $bar->start();

        foreach ($videos as $video) {
            // Delete video file if exists
            if ($video->video_file_path && Storage::disk('public')->exists($video->video_file_path)) {
                Storage::disk('public')->delete($video->video_file_path);
                $fileDeletedCount++;
            }

            // Delete thumbnail file if exists (if it's a file, not URL)
            if ($video->thumbnail) {
                // Check if it's a local file (contains /storage/ or doesn't start with http)
                if (str_contains($video->thumbnail, '/storage/')) {
                    $thumbnailPath = str_replace('/storage/', '', $video->thumbnail);
                    if (Storage::disk('public')->exists($thumbnailPath)) {
                        Storage::disk('public')->delete($thumbnailPath);
                        $thumbnailDeletedCount++;
                    }
                } elseif (!str_starts_with($video->thumbnail, 'http://') && 
                          !str_starts_with($video->thumbnail, 'https://')) {
                    // Direct path without /storage/ prefix
                    if (Storage::disk('public')->exists($video->thumbnail)) {
                        Storage::disk('public')->delete($video->thumbnail);
                        $thumbnailDeletedCount++;
                    }
                }
            }

            // Delete video record
            $video->delete();
            $deletedCount++;

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Selesai!");
        $this->line("   - Video yang dihapus: {$deletedCount}");
        $this->line("   - File video yang dihapus: {$fileDeletedCount}");
        $this->line("   - File thumbnail yang dihapus: {$thumbnailDeletedCount}");

        return 0;
    }
}
