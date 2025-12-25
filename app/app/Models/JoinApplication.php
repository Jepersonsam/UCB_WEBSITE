<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'voice_part',
        'experience',
        'reason',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];
}
