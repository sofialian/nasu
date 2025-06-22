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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('furniture_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamp('purchased_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_furniture');
    }
};
