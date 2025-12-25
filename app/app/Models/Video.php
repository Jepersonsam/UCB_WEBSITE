<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'video_url',
        'video_file_path',
        'video_type',
        'video_mime_type',
        'video_size',
        'thumbnail',
        'duration',
        'category',
        'views',
    ];
}

