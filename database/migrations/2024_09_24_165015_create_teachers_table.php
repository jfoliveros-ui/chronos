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
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id')->comment('identificador de la tabla');
            $table->string('type_document')->comment('Tipo de documento');
            $table->string('document_number')->comment('Numero de documento')->unique();
            $table->string('full_name')->comment('Nombre completo de la persona');
            $table->string('address')->comment('Direccion de residencia');
            $table->string('origin')->comment('Ciudad de origen');
            $table->string('phone')->comment('numero de contacto');
            $table->string('email')->comment('Correo electronico');
            $table->string('categorie')->comment('Categoria del docente');
            $table->enum('pensioner', ['Si', 'No'])->comment('Verifica si es pensionado o no.');
            $table->string('curriculum')->comment('ruta donde se guardara la hoja de vida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
