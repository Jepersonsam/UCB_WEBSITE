<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('join_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('voice_part')->nullable();
            $table->text('experience')->nullable();
            $table->text('reason')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('join_applications');
    }
};
