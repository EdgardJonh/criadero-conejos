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
        Schema::create('manejo_sanitario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conejo_id')->constrained('conejos')->onDelete('cascade');
            $table->date('fecha_control');
            $table->enum('tipo_control', ['Vacunación', 'Desparasitación', 'Revisión médica', 'Tratamiento', 'Enfermedad', 'Otro']);
            $table->string('producto_aplicado', 100)->nullable();
            $table->string('dosis', 50)->nullable();
            $table->enum('via_administracion', ['Oral', 'Inyectable', 'Tópica'])->nullable();
            $table->string('veterinario', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->date('proximo_control')->nullable();
            $table->enum('estado', ['Pendiente', 'Completado', 'En tratamiento', 'Recuperado'])->default('Completado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manejo_sanitario');
    }
};
