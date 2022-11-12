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
        Schema::create('venta_aguas', function (Blueprint $table) {
            $table->bigIncrements('id_venta_agua')->comment('id de venta del agua');
            $table->unsignedBigInteger('id_embarcacion')->comment('id de la embarcación');

            //datos de venta
            $table->decimal('monto_agua',10,2)->nullable()->comment('monto de venta de agua');
            $table->string('contometro_agua')->nullable()->comment('contómetro de agua');
            $table->string('fecha_venta_agua')->nullable()->comment('fecha de venta');

            
            //AUDITORIA
            $table->string('user_create_venta')->nullable()->comment('Usuario quien registra');
            $table->string('user_sede')->nullable()->comment('sede donde se registra');

            $table->foreign('id_embarcacion')->references('id')->on('embarcacions');
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
        Schema::dropIfExists('venta_agua');
    }
};
