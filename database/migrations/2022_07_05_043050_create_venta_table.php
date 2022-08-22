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
        Schema::create('ventas', function (Blueprint $table) {
            //IDS
            $table->bigIncrements('id_venta')->comment('id de venta');
            $table->unsignedBigInteger('id_embarcacion')->comment('id de la embarcación');
            $table->unsignedBigInteger('id_producto')->comment('id del producto');
            $table->unsignedBigInteger('id_tipo_pago')->comment('id del tipo de pago');
            
            //VENTA DE PRODUCTO
            $table->decimal('precio_x_galon_venta',10,2)->nullable()->comment('monto de galonaje de venta');
            $table->decimal('galonaje_venta',10,2)->nullable()->comment('monto de galonaje de venta');
            $table->decimal('monto_inicial_venta',10,2)->nullable()->comment('Monto incial antes de la venta');
            $table->decimal('precio_venta',10,2)->nullable()->comment('precio de venta');
            $table->string('moneda_venta')->nullable()->comment('moneda de venta');
            $table->string('nombre_producto')->nullable()->comment('nombre de producto');
            $table->string('observacion_venta')->nullable()->comment('observacion de la venta');

            //REFERENCIA
            $table->string('nombre_ref_venta')->nullable()->comment('nombre de referencia');
            $table->string('dni_ref_venta')->nullable()->comment('dni de referencia');
            $table->string('telefono_ref_venta')->nullable()->comment('telefono de referencia');
            $table->string('fecha_venta')->nullable()->comment('Fecha de la venta');

            //ESTADO
            $table->string('estado_venta')->nullable()->comment('Estado Venta : activo - anulado');
            
            //CONDICIONALES
            $table->string('mostrar_venta')->nullable()->comment('si se muestra la venta  o no');
            
            //AUDITORIA
            $table->string('user_create_venta')->nullable()->comment('Usuario quien registra');
            $table->string('user_sede')->nullable()->comment('sede donde se registra');
            $table->timestamps();

            //CLAVES FORANEAS
            $table->foreign('id_producto')->references('id_producto')->on('products');
            $table->foreign('id_embarcacion')->references('id')->on('embarcacions');
            $table->foreign('id_tipo_pago')->references('id_tipo_pago')->on('tipo_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
