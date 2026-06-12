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
        // Relaciones de la tabla USERS
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_rol')->references('id')->on('roles');
            $table->foreign('id_dependencia')->references('id')->on('ca_dependencias');
        });

        // Relaciones de la tabla ca_dependencias
        Schema::table('ca_dependencias', function (Blueprint $table) {
            $table->foreign('tipo_dependencia')->references('id')->on('ca_tipo_dependencia');
        });

        // Relaciones de la tabla ca_modulos
        Schema::table('ca_modulos', function (Blueprint $table) {
            $table->foreign('id_categoria')->references('id')->on('ca_categoria_modulos');
            $table->foreign('tipo_modulo')->references('id')->on('ca_tipo_modulo');
        });

        // Relaciones de la tabla ca_fracciones
        Schema::table('ca_fracciones', function (Blueprint $table) {
            $table->foreign('id_articulo')->references('id')->on('ca_articulos');
        });

        // Relaciones de la tabla ca_adjuntos_fracciones
        Schema::table('ca_adjuntos_fracciones', function (Blueprint $table) {
            $table->foreign('id_fraccion')->references('id')->on('ca_fracciones');
        });

        // Relaciones de la tabla ca_gabinete
        Schema::table('ca_gabinete', function (Blueprint $table) {
            $table->foreign('id_dependencia')->references('id')->on('ca_dependencias');
        });

        // Relaciones de la tabla ma_portales
        Schema::table('ma_portales', function (Blueprint $table) {
            $table->foreign('id_tipo_portal')->references('id')->on('ca_tipo_portal');
            $table->foreign('id_dependencia')->references('id')->on('ca_dependencias');
        });
        // Relaciones de la tabla re_rutas_rol
        Schema::table('re_rutas_rol', function (Blueprint $table) {
            $table->foreign('perfil_id')->references('id')->on('roles');
            $table->foreign('ruta_frontend_id')->references('id')->on('ca_rutas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Deshacemos las relaciones de la tabla ma_portales
        Schema::table('ma_portales', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_portal']);
            $table->dropForeign(['id_dependencia']);
        });

        // Deshacemos las relaciones de la tabla ca_gabinete
        Schema::table('ca_gabinete', function (Blueprint $table) {
            $table->dropForeign(['id_dependencia']);
        });

        // Deshacemos las relaciones de la tabla ca_adjuntos_fracciones
        Schema::table('ca_adjuntos_fracciones', function (Blueprint $table) {
            $table->dropForeign(['id_fraccion']);
        });

        // Deshacemos las relaciones de la tabla ca_fracciones
        Schema::table('ca_fracciones', function (Blueprint $table) {
            $table->dropForeign(['id_articulo']);
        });

        // Deshacemos las relaciones de la tabla ca_modulos
        Schema::table('ca_modulos', function (Blueprint $table) {
            $table->dropForeign(['id_categoria']);
            $table->dropForeign(['tipo_modulo']);
        });

        // Deshacemos las relaciones de la tabla ca_dependencias
        Schema::table('ca_dependencias', function (Blueprint $table) {
            $table->dropForeign(['tipo_dependencia']);
        });

        // Deshacemos las relaciones de la tabla USERS
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_rol']);
            $table->dropForeign(['id_dependencia']);
        });

        // Deshacemos las relaciones de la tabla roles_rutas
        Schema::table('re_rutas_rol', function (Blueprint $table) {
            $table->dropForeign(['perfil_id']);
            $table->dropForeign(['ruta_frontend_id']);
        });    }
};