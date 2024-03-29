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
        Schema::create('copy_of__maquinas', function (Blueprint $table) {
            $table->id();
            $table->unSignedBigInteger('horario_presencial_id');
            $table->foreign('horario_presencial_id')->references('id')->on('horarios__presenciales');
            $table->unSignedBigInteger('maquina_id');
            $table->foreign('maquina_id')->references('id')->on('maquinas');
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
        Schema::dropIfExists('copy_of__maquinas');
    }
};
