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
        Schema::create('mo_sitios_interes_detalle', function (Blueprint $table) {
            $table->id();
            $table->string('url_sitio');
            $table->enum('tipo_link', ['Interno', 'Externo'])->nullable();
            $table->integer('orden');
            $table->string('url_imagen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mo_sitios_interes_detalle');
    }
};
