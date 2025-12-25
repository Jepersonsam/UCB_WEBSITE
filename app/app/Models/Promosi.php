<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'link_text',
        'type',
        'is_active',
        'order',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
