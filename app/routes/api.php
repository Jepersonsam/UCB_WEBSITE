<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AuditionScheduleController;
use App\Http\Controllers\Api\PromosiController;
use App\Http\Controllers\Api\JoinApplicationController;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/user', [AuthController::class, 'user']);
    });
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);

    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::get('/gallery/albums/{id}', [GalleryController::class, 'show']);

    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{id}', [VideoController::class, 'show']);

    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);

    Route::get('/pages', [PageController::class, 'index']);
    Route::get('/pages/{slug}', [PageController::class, 'show']);
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/members/{id}', [MemberController::class, 'show']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    
    // Contact messages - public route for submitting messages
    Route::post('/contact-messages', [ContactMessageController::class, 'store']);
    
    // Comments - public routes
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    
    // Audition schedules - public routes
    Route::get('/audition-schedules', [AuditionScheduleController::class, 'index']);
    Route::get('/audition-schedules/{id}', [AuditionScheduleController::class, 'show']);

    // Promosi - public routes
    Route::get('/promosi', [PromosiController::class, 'index']);
    Route::get('/promosi/{id}', [PromosiController::class, 'show']);

    // Join applications - public route for submitting applications
    Route::post('/join-applications', [JoinApplicationController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/categories', CategoryController::class)->except(['index']);
        Route::apiResource('/tags', TagController::class)->except(['index']);
        Route::apiResource('/articles', ArticleController::class)->except(['index', 'show']);
        Route::post('/gallery/albums', [GalleryController::class, 'store']);
        Route::put('/gallery/albums/{id}', [GalleryController::class, 'update']);
        Route::delete('/gallery/albums/{id}', [GalleryController::class, 'destroy']);
        Route::post('/gallery/upload', [GalleryController::class, 'upload']);
        Route::delete('/gallery/media/{id}', [GalleryController::class, 'deleteMedia']);
        Route::post('/gallery/albums/{id}/attach-media', [GalleryController::class, 'attachMedia']);
        Route::post('/gallery/albums/{id}/detach-media', [GalleryController::class, 'detachMedia']);

        Route::apiResource('/videos', VideoController::class)->except(['index', 'show']);
        Route::apiResource('/events', EventController::class)->except(['index', 'show']);

        Route::post('/pages', [PageController::class, 'store']);
        Route::put('/pages/{id}', [PageController::class, 'update']);
        Route::delete('/pages/{id}', [PageController::class, 'destroy']);

        Route::put('/settings', [SettingController::class, 'update']);

        Route::apiResource('/members', MemberController::class)->except(['index', 'show']);
        // Add POST route for FormData compatibility (with _method=PUT)
        Route::post('/members/{id}', [MemberController::class, 'update']);
        
        // Contact messages - protected routes for managing messages
        Route::get('/contact-messages', [ContactMessageController::class, 'index']);
        Route::get('/contact-messages/{id}', [ContactMessageController::class, 'show']);
        Route::put('/contact-messages/{id}', [ContactMessageController::class, 'update']);
        Route::delete('/contact-messages/{id}', [ContactMessageController::class, 'destroy']);
        
        // Comments - protected routes for managing comments
        Route::get('/comments/{id}', [CommentController::class, 'show']);
        Route::put('/comments/{id}', [CommentController::class, 'update']);
        Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
        
        // Audition schedules - protected routes for managing schedules
        Route::apiResource('/audition-schedules', AuditionScheduleController::class)->except(['index', 'show']);

        // Promosi - protected routes for managing promosi
        Route::apiResource('/promosi', PromosiController::class)->except(['index', 'show']);
        
        // Join applications - protected routes for managing applications
        Route::get('/join-applications', [JoinApplicationController::class, 'index']);
        Route::get('/join-applications/{id}', [JoinApplicationController::class, 'show']);
        Route::put('/join-applications/{id}', [JoinApplicationController::class, 'update']);
        Route::delete('/join-applications/{id}', [JoinApplicationController::class, 'destroy']);
        Route::get('/join-applications/export/pdf', [JoinApplicationController::class, 'exportPDF']);
        Route::get('/join-applications/export/excel', [JoinApplicationController::class, 'exportExcel']);
    });
});

