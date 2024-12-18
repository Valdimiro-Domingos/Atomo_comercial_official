<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->date('data')->nullable();
            $table->string('serie')->nullable();
            $table->string('numero')->nullable();
            $table->string('ref_doc')->nullable();
            $table->string('armazem')->nullable();
            $table->string('fornecedor_nome')->nullable();
            $table->string('endereco')->nullable();
            $table->string('descricao')->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('fornecedor_id')->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors')->onDelete('no action');
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
        Schema::dropIfExists('stocks');
    }
}