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
            $table->string('estudiante_id', 20)->primary();
            $table->string('nombre_estudiante', 100);
            $table->integer('edad');
            $table->string('direccion', 100)->nullable();
            $table->unsignedBigInteger('telefono')->nullable();
            $table->integer('estado')->default(1);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
