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
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->string('image_path');
            $table->integer('width')->default(50);
            $table->integer('height')->default(50);
            $table->string('category')->default('decor');
            $table->boolean('is_purchasable')->default(true);
            $table->boolean('is_default')->default(false);

            // Nuevas columnas para sprites
            $table->integer('sprite_columns')->default(4); // número de frames horizontales
            $table->integer('sprite_width')->nullable();   // ancho de cada frame
            $table->integer('sprite_height')->nullable();  // alto de cada frame

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furniture');
    }
};
