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
        Schema::create('mo_noticias_detalle', function (Blueprint $table) {
            $table->id();
            $table->string('titular_nota')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('metadata')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mo_noticias_detalle');
    }
};
