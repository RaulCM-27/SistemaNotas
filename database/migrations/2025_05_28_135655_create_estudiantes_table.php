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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->integer('estudiante_id')->primary(); // Clave primaria
            $table->string('nombre_estudiante', 100);
            $table->integer('edad');
            $table->string('direccion', 100);
            $table->bigInteger('telefono');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
