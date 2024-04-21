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
            $table->string('dni', 8)->unique();
            $table->string('direccion', 100);
            $table->date('fecha_nacimiento');
            $table->integer('ciclo_de_estudiante');
            $table->boolean('estado')->default(True);
            $table->unSignedBigInteger('institucion_id');
            $table->foreign('institucion_id')->references('id')->on('institucions');
            $table->unSignedBigInteger('carrera_id');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->string('correo')->unique()->nullable();
            $table->string('celular')->unique()->nullable();
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
