<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigos', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('codigo')->nullable();
            $table->string('designacao')->nullable();
            $table->foreignId('tipo_id')->nullable();
            $table->foreignId('retencao_id')->nullable();
            $table->foreignId('categoria_id')->nullable();
            $table->foreignId('imposto_id')->nullable();
            $table->double('preco')->nullable();
            $table->string('imagem_1')->nullable();
            $table->string('imagem_2')->nullable();
            $table->string('imagem_3')->nullable();
            $table->string('unidade')->nullable();
            $table->foreignId('fornecedor_id')->nullable();
            $table->string('codigo_barra')->nullable();
            $table->boolean('is_stock')->nullable();
            $table->string('stock_minimo')->nullable();
            $table->string('stock_maximo')->nullable();
            $table->string('observacao')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('is_used')->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipos')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('retencao_id')->references('id')->on('retencaos')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('imposto_id')->references('id')->on('impostos')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('artigos');
    }
}