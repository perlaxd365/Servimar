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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->bigIncrements('id_kardex')->comment('id');
            $table->unsignedBigInteger('id_producto')->nullable()->comment('id del producto');
            $table->unsignedBigInteger('id_tipo_movimiento')->nullable()->comment('id del tipo de movimiento');
            $table->decimal('cantidad_kar',10,2)->nullable()->comment('Cantidad de movimiento');
            $table->decimal('total_kar',10,2)->nullable()->comment('Cantidad de movimiento');
            $table->string('user_create_kar')->nullable()->comment('Usuario quien registra');
            $table->timestamps();

            
            $table->foreign('id_producto')->references('id_producto')->on('products');
            $table->foreign('id_tipo_movimiento')->references('id_tipo_movimiento')->on('tipo_movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardexes');
    }
};
