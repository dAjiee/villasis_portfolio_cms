<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('experience_descriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('experience_id')->constrained('experiences', 'id', 'exp_desc_id')->cascadeOnDelete()->onDelete('cascade');
            $table->text('description');
            $table->integer('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_descriptions');
    }
};
