<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Media;
use App\Models\Video;
use App\Models\Event;
use App\Models\Member;

class DashboardController extends Controller
{
    public function stats()
    {
        $stats = [
            'articles' => Article::count(),
            'photos' => Media::where('type', 'image')->count(),
            'videos' => Video::count(),
            'events' => Event::count(),
            'members' => Member::where('is_active', true)->count(),
        ];

        return response()->json($stats);
    }
}

