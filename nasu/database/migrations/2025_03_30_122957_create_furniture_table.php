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
            $table->enum('current_view', ['front', 'back', 'left', 'right'])->default('front');
            $table->integer('width')->default(50);
            $table->integer('height')->default(50);
            $table->string('category')->default('decor');
            $table->boolean('is_purchasable')->default(true);
            $table->boolean('is_default')->default(false);
            // Nuevas columnas para sprites
            $table->integer('sprite_columns')->default(4); 
            $table->integer('sprite_width')->nullable();  
            $table->integer('sprite_height')->nullable();  

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
