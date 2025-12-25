<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column exists with wrong name and rename it
        if (Schema::hasColumn('join_applications', 'is_rand')) {
            Schema::table('join_applications', function (Blueprint $table) {
                $table->renameColumn('is_rand', 'is_read');
            });
        } elseif (!Schema::hasColumn('join_applications', 'is_read')) {
            // If neither column exists, add is_read
            Schema::table('join_applications', function (Blueprint $table) {
                $table->boolean('is_read')->default(false)->after('reason');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('join_applications', 'is_read')) {
            Schema::table('join_applications', function (Blueprint $table) {
                $table->renameColumn('is_read', 'is_rand');
            });
        }
    }
};
