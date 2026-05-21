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
        Schema::create('mo_boletin_detalle', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['hidro', 'geo']);
            $table->string('descripcion');
            $table->string('url_boletin');
            $table->longtext('nota');
            $table->json('metadatos');
            $table->integer('orden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mo_boletin_detalle');
    }
};
