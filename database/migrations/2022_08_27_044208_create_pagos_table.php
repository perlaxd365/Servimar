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
        Schema::create('pagos', function (Blueprint $table) {
            //id
            $table->bigIncrements('id_pago')->comment('id del pago');
            $table->unsignedBigInteger('id_cliente')->comment('id del cliente');
            //pago
            
            $table->decimal('monto_pago',10,2)->nullable()->comment('monto de pago de la embarcación');

            //datos de auditoria
            $table->string('user_create_venta')->nullable()->comment('Usuario quien registra');
            $table->string('user_sede')->nullable()->comment('sede donde se registra');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id_cliente')->on('clientes');
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
        Schema::dropIfExists('pagos');
    }
};
