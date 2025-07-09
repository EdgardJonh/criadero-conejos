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
        Schema::create('conejos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('foto_principal');
            $table->json('fotos_adicionales')->nullable();
            $table->string('numero');
            $table->string('raza');
            $table->string('color')->nullable();
            $table->string('sexo')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conejos');
    }
};
