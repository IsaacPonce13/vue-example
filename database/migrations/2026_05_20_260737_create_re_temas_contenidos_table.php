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
        Schema::create('re_temas_contenidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tema')->constrained('ca_temas')->cascadeOnDelete();
            $table->foreignId('id_modulo')->constrained('ca_modulos')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('re_temas_contenidos');
    }
};
