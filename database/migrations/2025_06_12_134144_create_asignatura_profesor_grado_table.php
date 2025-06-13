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
        Schema::create('asignatura_profesor_grado', function (Blueprint $table) {
            $table->id();
            $table->integer('profesor_id');
            $table->integer('id_asignatura');
            $table->integer('id_grado');

            // Llaves foráneas correctamente enlazadas
            $table->foreign('profesor_id')->references('profesor_id')->on('profesores')->onDelete('cascade');
            $table->foreign('id_asignatura')->references('id_asignatura')->on('asignaturas')->onDelete('cascade');
            $table->foreign('id_grado')->references('id_grado')->on('grados')->onDelete('cascade');

            // UNIQUE con nombre corto para evitar error 1059
            $table->unique(['profesor_id', 'id_asignatura', 'id_grado'], 'apg_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignatura_profesor_grado');
    }
};
