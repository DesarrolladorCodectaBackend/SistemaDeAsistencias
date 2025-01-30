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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semana_id');
            $table->foreign('semana_id')->references('id')->on('semanas');
            $table->bigInteger('nro_pago')->unique();
            $table->string('nombres');
            $table->bigInteger('dni');
            $table->text('descripcion');
            $table->decimal('monto', 5, 2);
            $table->unsignedBigInteger('tipo_transaccion_id');
            $table->foreign('tipo_transaccion_id')->references('id')->on('tipo_transacciones');
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
        Schema::dropIfExists('transacciones');
    }
};
