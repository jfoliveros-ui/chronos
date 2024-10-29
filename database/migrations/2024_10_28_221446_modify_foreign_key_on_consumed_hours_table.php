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
        Schema::table('consumed_hours', function (Blueprint $table) {
            // Agregar la clave foránea con eliminación en cascada
            $table->foreign('schedules_id')
                  ->references('id')
                  ->on('schedules')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consumed_hours', function (Blueprint $table) {
            // Eliminar la relación con cascada
            $table->dropForeign(['schedules_id']);
    
            // Restaurar la relación original (sin eliminar en cascada)
            $table->foreign('schedules_id')
                  ->references('id')
                  ->on('schedules');
        });
    }
};
