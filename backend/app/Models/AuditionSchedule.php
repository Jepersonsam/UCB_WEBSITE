<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'audition_date',
        'start_time',
        'end_time',
        'location',
        'requirements',
        'notes',
        'is_active',
        'max_participants',
    ];

    protected $casts = [
        'audition_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
        'max_participants' => 'integer',
    ];
}
