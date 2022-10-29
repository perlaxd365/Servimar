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
        Schema::create('contometros', function (Blueprint $table) {
            //id
            $table->bigIncrements('id_contometro')->comment('id del contometro');
            $table->unsignedBigInteger('id_venta')->nullable()->comment('id de la venta');
            $table->unsignedBigInteger('id_jornada')->nullable()->comment('id de la jornada');
            $table->unsignedBigInteger('id_sede')->nullable()->comment('id de la sede (punto)');

            //datos de contrometro
            $table->string('contometro_1')->nullable()->comment('contometro con una sola medida');
            $table->string('contometro_a')->nullable()->comment('contometro con doble medida a');
            $table->string('contometro_b')->nullable()->comment('contometro con doble medida b');

            //estado
            $table->string('estado_contometro')->nullable()->comment('Estado contometro : activo - anulado');

            //datos de auditoria
            $table->string('user_create')->nullable()->comment('Usuario quien registra');
            $table->string('user_sede')->nullable()->comment('sede donde se registra');
            $table->timestamps();

            $table->foreign('id_venta')->references('id_venta')->on('ventas');
            $table->foreign('id_jornada')->references('id_jornada')->on('jornadas');
            $table->foreign('id_sede')->references('id_sede')->on('sedes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contometro');
    }
};
