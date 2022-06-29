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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id_producto')->comment('id');
            $table->unsignedBigInteger('id_sede')->nullable()->comment('id de la sede en donde se ubicara el producto');
            $table->string('nombre_pro')->nullable()->comment('Nombre del producto');
            $table->decimal('stock_pro',10,2)->nullable()->comment('Stock del producto');
            $table->string('unidad_pro')->nullable()->comment('Unidad del producto');
            $table->boolean('estado_pro')->nullable()->comment('Estado');
            $table->timestamps();

            
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
        Schema::dropIfExists('products');
    }
};
