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
            $table->string('name'); // E.g., "Blue Chair"
            $table->string('image_path');
            $table->json('metadata')->nullable(); // E.g., { "width": 50, "height": 50, "can_sit": true }
            $table->integer('price'); // Cost in beans
            $table->boolean('is_purchasable')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furnitures');
    }
};
