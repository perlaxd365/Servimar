<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('jornadas', function (Blueprint $table) {
            $table->bigIncrements('id_jornada')->comment('id de la jornada');
            $table->unsignedBigInteger('id_user')->nullable()->comment('id del usuario');
            //datos de jornada
            $table->string('entrada_jornada')->nullable()->comment('Fecha y hora de entrada');
            $table->string('salida_jornada')->nullable()->comment('Fecha y hora de salida');
            $table->boolean('estado_jornada')->nullable()->comment('Estado 1 -> Activo , Estado 0 -> Finalizado');


            //datos de auditoria
            $table->string('user_create_jornada')->nullable()->comment('Usuario quien registra');
            $table->string('user_sede')->nullable()->comment('sede donde se registra');
            $table->timestamps();

            //CLAVES FORANEAS
            $table->foreign('id_user')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jornadas');
    }
};
