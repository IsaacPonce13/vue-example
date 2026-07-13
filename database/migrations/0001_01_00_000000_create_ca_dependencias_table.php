<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ca_dependencias', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('adscripcion');
            // $table->string('url_portal_unico');
            $table->integer('id_padre');
            $table->json('metadatos');
            $table->string('shortname');
            $table->unsignedBigInteger('tipo_dependencia')->nullable();
            $table->string('telefono', length: 20);
            $table->string('email');
            $table->string('horarios');
            $table->integer('codigo_postal');
            $table->string('calle_numero');
            $table->string('colonia');
            $table->string('id_municipio');
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_dependencias');
    }
};
