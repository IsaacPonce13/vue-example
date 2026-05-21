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
        Schema::create('ca_gabinete', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('cargo')->nullable();
            $table->text('resumen')->nullable();
            $table->date('periodo')->nullable();
            $table->unsignedBigInteger('id_dependencia');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_gabinete');
    }
};
