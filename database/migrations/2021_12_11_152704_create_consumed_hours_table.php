<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumedHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumed_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('schedules_id')->comment('trae la informacion del la clase con la información del docente.');
            $table->foreign('schedules_id')->references('id')->on('schedules');
            $table->string('consumed_hours')->comment('horas consumidas por el docente');
            $table->string('cut')->comment('corte del año en el que se consume el tiempo, corte 1 o corte 2');
            $table->string('year')->comment('año de presentación');
            $table->string('categorie')->comment('Categoria a la que pertenece la persona.');
            $table->string('value_hour')->comment('Valor de la hora segun categoria.');
            $table->string('resolution')->comment('Resolución de la clase');
            $table->string('value_pensioner')->comment('porcentaje que maneja si es pensionado se calcula ((value_hour x consumed_hours) x valuePensioner)/100.')->nullable();
            $table->string('value_total')->comment('valor total pagado de la clase se calcula con (value_hour x consumed_hours) + value_pensioner.')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cosumed_hours');
    }
}
