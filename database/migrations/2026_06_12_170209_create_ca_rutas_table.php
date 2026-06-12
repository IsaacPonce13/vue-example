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
        Schema::create('ca_rutas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruta')->nullable();
            $table->string('icono')->nullable();
            $table->string('orden')->nullable();
            $table->boolean('mostrar_menu')->default(0);

            $table->unsignedInteger('padre_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_rutas');
    }
};
