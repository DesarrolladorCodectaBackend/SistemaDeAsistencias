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
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->float('pasaje', 5, 2)->nullable();
            $table->float('comida', 5, 2)->nullable();
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
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn('pasaje');
            $table->dropColumn('comida');
            $table->dropColumn('especialista_id');
        });
    }
};
