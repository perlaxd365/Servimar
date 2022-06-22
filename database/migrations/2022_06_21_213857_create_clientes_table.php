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
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id_cliente')->comment('id del cliente');
            $table->unsignedBigInteger('id_persona')->nullable()->comment('id de persona: natural o juridica');
            $table->unsignedBigInteger('id_tipo_cliente')->nullable()->comment('id tipo cliente');
            $table->string('ruc_cli')->nullable()->comment('ruc del cliente');
            $table->string('dni_cli')->nullable()->comment('dni del cliente');
            $table->string('razon_cli')->nullable()->comment('razon del cliente');
            $table->string('nombre_cli')->comment('nombres del cliente');
            $table->string('telefono_cli')->nullable()->comment('telefono del cliente');
            $table->string('email_cli')->nullable()->comment('email del cliente');
            $table->boolean('estado_cli')->comment('estado del cliente');
            $table->timestamps();

            //relacion con tabla persona
            $table->foreign('id_persona')->references('id_persona')->on('personas');
            //relacion con tabla tipocliente
            $table->foreign('id_tipo_cliente')->references('id_tipo_cliente')->on('tipo_clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
