<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ca_modulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            /* REGLA POLIMÓRFICA: Esta es una función mágica de Laravel. Al escribir esa sola línea, Laravel crea automáticamente por ti:
                detalle_id (BigInteger, aceptando nulos).
                detalle_type (String, para guardar cosas como App\Models\NoticiaDetalle).
                Índices compuestos: Crea un índice de base de datos que agrupa ambas columnas, haciendo que buscar los detalles de tus módulos sea extremadamente rápido.
            */
            $table->nullableMorphs('detalle'); 
            
            $table->longText('contenido')->nullable();
            $table->unsignedBigInteger('id_categoria')->constrained('ca_categorias_modulos')->nullOnDelete();
            $table->unsignedBigInteger('tipo_modulo');
            $table->enum('estado', ['borrador', 'programada', 'publicado', 'archivado'])->nullable()->default('borrador');
            $table->dateTime('fecha_alta');
            $table->dateTime('fecha_pub_programada')->nullable();
            $table->dateTime('fecha_baja')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_modulos');
    }
};