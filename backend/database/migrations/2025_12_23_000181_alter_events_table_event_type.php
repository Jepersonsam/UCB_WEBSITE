<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change event_type from enum to string
        Schema::table('events', function (Blueprint $table) {
            // First, we need to drop the enum constraint
            DB::statement("ALTER TABLE events MODIFY COLUMN event_type VARCHAR(255) DEFAULT 'lainnya'");
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Revert back to enum
            DB::statement("ALTER TABLE events MODIFY COLUMN event_type ENUM('latihan', 'konser', 'pelayanan', 'lainnya') DEFAULT 'lainnya'");
        });
    }
};

