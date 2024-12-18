<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondicoesPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condicoes_pagamentos', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->string('codigo')->nullable();
            $table->string('designacao')->nullable();
            $table->string('descricao')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('condicoes_pagamentos');
    }
}
