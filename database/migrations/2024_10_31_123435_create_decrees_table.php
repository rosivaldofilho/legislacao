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
            $table->string('number')->unique();// Número do decreto
            $table->json('doe_numbers')->nullable();// Números do DOE
            $table->timestamp('effective_date');// Data do documento
            $table->string('summary', 255);// Ementa
            $table->string('content');// Conteúdo
            $table->string('file_pdf')->nullable();// Arquivo PDF
            $table->foreignId('user_id')->constrained()->onDelete('cascade');// Usuário
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
