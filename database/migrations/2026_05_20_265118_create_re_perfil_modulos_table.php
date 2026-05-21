<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('re_perfil_modulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_perfil')->constrained('ca_perfil_visitantes')->cascadeOnDelete();
            $table->foreignId('id_modulo')->constrained('ca_modulos')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('re_perfil_modulos');
    }
};
