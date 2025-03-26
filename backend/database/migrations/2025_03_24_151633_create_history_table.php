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
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
            $table->foreignId('task_id')->nullable()->constrained('tareas')->onDelete('set null');
            $table->timestamp('completed_at')->useCurrent();
            $table->integer('gained_exp')->default(0);
            $table->integer('gained_beans')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
