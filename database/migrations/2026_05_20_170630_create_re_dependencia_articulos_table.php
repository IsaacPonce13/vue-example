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
        Schema::create('re_dependencia_articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_dependencia')->constrained('ca_dependencias')->cascadeOnDelete();
            $table->foreignId('id_articulo')->constrained('ca_articulos')->cascadeOnDelete();
            $table->tinyInteger('aplicable')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('re_dependencia_articulos');
    }
};
