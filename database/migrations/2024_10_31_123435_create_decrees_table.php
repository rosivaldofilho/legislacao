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
        Schema::create('decrees', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('effective_date');
            $table->string('summary', 255);
            $table->string('content');
            $table->string('filePath');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->softDeletes(); // Para implementar exclusão lógica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decrees');
    }
};
