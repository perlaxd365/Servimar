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
        Schema::create('embarcacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente')->nullable()->comment('id de cliente');
            $table->string('nombre_emb')->nullable()->comment('nombre de embarcación');
            $table->string('matricula_emb')->nullable()->comment('matrícula de embarcación');
            $table->string('duenio_emb')->nullable()->comment('dueño de embarcación');
            $table->string('telefono_emb')->nullable()->comment('telefono del dueño');
            $table->string('user_create_emb')->nullable()->comment('telefono del dueño');
            $table->boolean('estado_emb')->nullable()->comment('estado de la embarcación');
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
        Schema::dropIfExists('embarcacions');
    }
};
