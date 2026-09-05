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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('duracion');
            $table->text('adj_video')->nullable();
            $table->text('tipo_hotel')->nullable();
            $table->string('can_personas')->nullable();
            $table->string('altitud')->nullable();
            $table->enum('tipo', ['paquete', 'tour', 'treks', 'diferente']);
            $table->enum('dificultad', ['Baja', 'Media', 'Alta']);
            $table->enum('estado', ['activo', 'inactivo']);
            $table->string('adj_pdf')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('imagen')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10,2)->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
