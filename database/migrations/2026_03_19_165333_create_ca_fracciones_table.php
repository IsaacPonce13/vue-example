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
        Schema::create('ca_fracciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_articulo');
            $table->unsignedBigInteger('id_adjunto');
            $table->integer('no_fraccion');
            $table->string('titulo');
            $table->text('contenido')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('aplicable')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_fracciones');
    }
};
