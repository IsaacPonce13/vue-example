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
        Schema::table('roles', function (Blueprint $table) {
            // Laravel ya sabe que es la tabla 'roles'
            $table->string('description')->nullable()->after('guard_name');
            $table->string('color')->nullable()->after('description');
            $table->boolean('active')->default(true)->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['description', 'color', 'is_active']);
        });
    }
};