<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('datos_empresa') && ! Schema::hasColumn('datos_empresa', 'horario')) {
            Schema::table('datos_empresa', function (Blueprint $table) {
                $table->string('horario')->nullable();
            });
        }

        if (Schema::hasTable('paquetes') && ! Schema::hasColumn('paquetes', 'categoria_id')) {
            Schema::table('paquetes', function (Blueprint $table) {
                $table->unsignedBigInteger('categoria_id')->nullable()->index();
            });
        }

        if (! Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('slug')->unique();
                $table->string('img')->nullable();
                $table->text('descripcion')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('testimonios')) {
            Schema::create('testimonios', function (Blueprint $table) {
                $table->id();
                $table->string('nombres');
                $table->string('cargo')->nullable();
                $table->text('texto')->nullable();
                $table->string('estado', 20)->default('activo')->index();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Conserva datos existentes: no elimina tablas ni columnas.
    }
};
