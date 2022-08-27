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
        Schema::create('detalle_pagos', function (Blueprint $table) {
            //id
            $table->bigIncrements('id_detalle_pago')->comment('id del detalle de pago');
            $table->unsignedBigInteger('id_credito')->nullable()->comment('id del credito');
            $table->unsignedBigInteger('id_pago')->comment('id del pago');
            //pago

            $table->decimal('monto_detalle_pago', 10, 2)->nullable()->comment('monto de pago de la embarcación');
            $table->string('tipo_pago')->nullable()->comment('pago o credito');
            $table->string('fecha_pago')->nullable()->comment('fecha del pago');

            
            //datos de auditoria
            $table->string('user_create_venta')->nullable()->comment('Usuario quien registra');
            $table->string('user_sede')->nullable()->comment('sede donde se registra');
            $table->timestamps();

            $table->foreign('id_credito')->references('id_credito')->on('creditos');
            $table->foreign('id_pago')->references('id_pago')->on('pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('detalle_pagos');
    }
};
