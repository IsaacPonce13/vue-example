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
        Schema::create('ma_portales', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->string('url');
            $table->unsignedBigInteger('id_tipo_portal');
            $table->unsignedBigInteger('id_dependencia');
            $table->enum('estado', ['borrador', 'programada', 'publicado', 'archivado'])->default('borrador')->nullable();
            $table->dateTime('fecha_alta');
            $table->dateTime('fecha_pub_programada')->nullable();
            $table->dateTime('fecha_baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ma_portales');
    }
};
