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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            $table->enum('dia', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']);
            $table->time('hora_inicio');
            $table->time('hora_fin');

            // Campos foráneos
            $table->integer('id_grado');
            $table->unsignedBigInteger('id_asignacion');

            // Relaciones
            $table->foreign('id_grado')->references('id_grado')->on('grados')->onDelete('restrict');
            $table->foreign('id_asignacion')->references('id')->on('asignatura_profesor')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
