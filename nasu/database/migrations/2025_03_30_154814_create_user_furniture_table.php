<?php

// database/migrations/YYYY_MM_DD_create_user_furniture_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_furniture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('furniture_id')->constrained()->cascadeOnDelete();
            $table->timestamp('purchased_at');
            $table->boolean('is_placed')->default(false);

            // These columns should be in the furniture table, not user_furniture
            // $table->integer('width')->default(50);
            // $table->integer('height')->default(50);
            // $table->boolean('is_purchasable')->default(true);
            // $table->boolean('is_default')->default(false);

            $table->timestamps();

            // Optional: Add index for better performance
            $table->index(['user_id', 'furniture_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_furniture');
    }
};
