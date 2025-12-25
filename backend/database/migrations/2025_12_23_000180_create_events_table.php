<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('event_type', ['latihan', 'konser', 'pelayanan', 'lainnya'])->default('lainnya');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('venue')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_pattern')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

