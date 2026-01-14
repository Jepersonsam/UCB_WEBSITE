<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('video_file_path')->nullable()->after('video_url');
            $table->string('video_type')->default('url')->after('video_file_path'); // 'url' or 'file'
            $table->string('video_mime_type')->nullable()->after('video_type');
            $table->unsignedBigInteger('video_size')->nullable()->after('video_mime_type');
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['video_file_path', 'video_type', 'video_mime_type', 'video_size']);
        });
    }
};

