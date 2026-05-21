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
        Schema::create('re_redes_dependencia', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->foreignId('id_red_social')->constrained('ca_redes_sociales');
            $table->foreignId('id_dependencia')->constrained('ca_dependencias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('re_redes_dependencia');
    }
};
