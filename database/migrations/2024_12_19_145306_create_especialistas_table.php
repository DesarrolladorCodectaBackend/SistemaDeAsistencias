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
        Schema::create('especialistas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('correo')->nullable();
            $table->string('celular')->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->unsignedBigInteger('especialista_id')->nullable()->after('candidato_id');

            $table->foreign('especialista_id')->references('id')->on('especialistas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialistas');
    }
};
