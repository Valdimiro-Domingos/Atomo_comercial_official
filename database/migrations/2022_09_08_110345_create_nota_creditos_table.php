<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_creditos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->string('numero')->nullable();
            $table->foreignId('cliente_id')->nullable();
            $table->string('cliente_nome')->nullable();
            $table->string('contribuinte')->nullable();
            $table->string('endereco')->nullable();
            $table->datetime('data')->nullable();
            $table->datetime('data_vencimento')->nullable();
            $table->foreignId('formapagamento_id')->nullable();
            $table->foreignId('moeda_id')->nullable();
            $table->foreignId('utilizador_id')->nullable();
            $table->string('utilizador_nome')->nullable();
            $table->text('observacao')->nullable();
            $table->decimal('subtotal', 30, 2)->nullable();
            $table->decimal('desconto', 30, 2)->nullable();
            $table->decimal('imposto', 30, 2)->nullable();
            $table->decimal('retencao', 30, 2)->nullable();
            $table->decimal('total', 30, 2)->nullable();
            $table->text('hash')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('documento_id')->nullable();
            $table->string('documento_numero')->nullable();
            $table->foreignId('motivo_anulacao_id')->nullable();
            $table->string('motivo_anulacao_designacao')->nullable();
            $table->foreignId('tipo_motivo_anulacao_id')->nullable();
            $table->string('tipo_motivo_anulacao_designacao')->nullable();
            $table->foreign('motivo_anulacao_id')->references('id')->on('motivo_anulacaos')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('tipo_motivo_anulacao_id')->references('id')->on('tipo_motivo_anulacaos')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('formapagamento_id')->references('id')->on('formas_pagamentos')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('moeda_id')->references('id')->on('moedas')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('utilizador_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('no action');
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
        Schema::dropIfExists('nota_creditos');
    }
}