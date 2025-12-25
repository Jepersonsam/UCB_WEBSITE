<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
    ];

    public function media()
    {
        return $this->belongsToMany(Media::class, 'album_media')->withPivot('sort_order');
    }
}

