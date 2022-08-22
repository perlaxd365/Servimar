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
        //
        Schema::create('creditos', function (Blueprint $table) {
            $table->bigIncrements('id_credito')->comment('id del credito');
            $table->unsignedBigInteger('id_embarcacion')->comment('id de la embarcación');
            $table->unsignedBigInteger('id_venta')->comment('id de la venta');
            
            $table->decimal('precio_galon_credito',10,2)->nullable()->comment(' precio de galones de credito');
            $table->decimal('galones_credito',10,2)->nullable()->comment('galones de credito');
            $table->decimal('monto_credito',10,2)->nullable()->comment('precio de credito');
            
            $table->string('fecha_credito')->nullable()->comment('Fecha de la venta');
            $table->boolean('estado_credito')->nullable()->comment('Estado credito : 1 activo - 0 pagado');
            $table->string('user_create_credito')->nullable()->comment('Usuario quien registra');
            $table->timestamps();

            $table->foreign('id_embarcacion')->references('id')->on('embarcacions');
            $table->foreign('id_venta')->references('id_venta')->on('ventas');
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
        Schema::dropIfExists('creditos');
    }
};
