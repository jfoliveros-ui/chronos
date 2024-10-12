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
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id')->comment('identificador de la tabla');
            $table->string('cetap')->comment('Lugar donde se presentara el docente');
            $table->string('semester')->comment('Semestre que se va a dictar');
            $table->string('subject')->comment('materia que se va a dictar');
            $table->unsignedInteger('teacher_id')->comment('identificación del docente.');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->string('mode')->comment('Modalidad de la clase - Precencial o Virtual');
            $table->date('date')->comment('fecha que se presentara el docente');
            $table->string('working_day')->comment('Jornada que se presenta el docente.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
