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
            //datos de jornada
            $table->string('entrada_jornada')->nullable()->comment('Fecha y hora de entrada');
            $table->string('salida_jornada')->nullable()->comment('Fecha y hora de salida');
            $table->boolean('estado_jornada')->nullable()->comment('Estado 1 -> Activo , Estado 0 -> Finalizado');


            //datos de auditoria
            $table->string('user_create_jornada')->nullable()->comment('Usuario quien registra');
            $table->string('user_sede')->nullable()->comment('sede donde se registra');
            $table->timestamps();
        });
        date_default_timezone_set('America/Lima');
        DB::table('jornadas')->insert(
            [
                'entrada_jornada'   => now()->format('d/m/Y H:i:s A'), 
                'estado_jornada'    => true,
                'user_create_jornada' => 'Cesar Raul Baca',
                'user_sede'         => 'Gildemeister'
            ]
        );
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
