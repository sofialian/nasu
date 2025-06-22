<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('furniture_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('furniture_id')->constrained()->onDelete('cascade');
            $table->enum('view', ['front', 'back', 'left', 'right']);
            $table->string('image_path');
            $table->integer('width');
            $table->integer('height');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('furniture_views');
    }
};
