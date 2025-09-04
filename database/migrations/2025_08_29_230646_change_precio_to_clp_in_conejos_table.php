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
        Schema::table('conejos', function (Blueprint $table) {
            // Cambiar el campo precio de decimal a integer para pesos chilenos
            $table->integer('precio')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conejos', function (Blueprint $table) {
            // Revertir el cambio de integer a decimal
            $table->decimal('precio', 10, 2)->change();
        });
    }
};
