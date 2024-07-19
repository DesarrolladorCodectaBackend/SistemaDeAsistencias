<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 8)->nullable(); //used to be unique
            $table->string('direccion', 100);
            $table->date('fecha_nacimiento');
            $table->integer('ciclo_de_estudiante');
            $table->boolean('estado')->default(True);
            $table->unSignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->unSignedBigInteger('carrera_id');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->string('correo')->nullable(); //used to be unique
            $table->string('celular')->nullable(); //used to be unique
            $table->string('icono');
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
        Schema::dropIfExists('candidatos');
    }
};
