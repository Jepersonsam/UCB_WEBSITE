<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_filename',
        'path',
        'type',
        'mime_type',
        'size',
        'width',
        'height',
        'alt_text',
        'caption',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_media')->withPivot('sort_order');
    }
}

