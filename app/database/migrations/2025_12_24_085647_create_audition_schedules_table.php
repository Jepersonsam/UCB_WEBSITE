<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audition_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('audition_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->text('requirements')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('max_participants')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audition_schedules');
    }
};
