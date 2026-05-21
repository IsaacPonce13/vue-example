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
        Schema::create('ca_multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('url');
            $table->string('ruta_carpeta');
            $table->enum('tipo', ['Imagen', 'Video', 'Documento'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_multimedia');
    }
};
