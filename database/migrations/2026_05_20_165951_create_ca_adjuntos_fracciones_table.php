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
        Schema::create('ca_adjuntos_fracciones', function (Blueprint $table) {
            $table->id();
            $table->string('archivo_path');
            $table->string('nombre_archivo');
            $table->unsignedBigInteger('id_fraccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_adjuntos_fracciones');
    }
};
