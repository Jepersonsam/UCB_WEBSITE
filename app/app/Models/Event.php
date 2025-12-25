<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_type',
        'start_date',
        'end_date',
        'location',
        'venue',
        'featured_image',
        'is_recurring',
        'recurring_pattern',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_recurring' => 'boolean',
    ];
}

