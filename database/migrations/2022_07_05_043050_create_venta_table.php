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
        Schema::create('venta', function (Blueprint $table) {
            $table->bigIncrements('id_venta')->comment('id de venta');
            $table->unsignedBigInteger('id_embarcacion')->comment('id de la embarcación');
            $table->unsignedBigInteger('id_producto')->comment('id del producto');
            $table->unsignedBigInteger('id_tipo_pago')->comment('id del tipo de pago');
            
            $table->decimal('galonaje_venta',10,2)->nullable()->comment('monto de galonaje de venta');
            $table->decimal('precio_venta',10,2)->nullable()->comment('precio de venta');
            $table->string('nombre_ref_venta')->nullable()->comment('nombre de referencia');
            $table->string('dni_ref_venta')->nullable()->comment('dni de referencia');
            $table->string('telefono_ref_venta')->nullable()->comment('telefono de referencia');
            $table->string('user_create_venta')->nullable()->comment('Usuario quien registra');
            $table->timestamps();

            
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
        Schema::dropIfExists('venta');
    }
};
