<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->string('designacao')->nullable();
            $table->decimal('preco', 30, 2)->nullable();
            $table->integer('qtd')->nullable();
            $table->decimal('desconto', 30, 2)->nullable();
            $table->decimal('subtotal', 30, 2)->nullable();
            $table->string('retencao_designacao')->nullable();
            $table->double('retencao_taxa')->nullable();
            $table->string('imposto_tipo')->nullable();
            $table->string('imposto_codigo')->nullable();
            $table->string('imposto_designacao')->nullable();
            $table->double('imposto_taxa')->nullable();
            $table->string('imposto_motivo')->nullable();
            $table->foreignId('factura_id');
            $table->foreignId('artigo_id');
            $table->foreignId('imposto_id');
            $table->foreignId('retencao_id')->nullable();
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
            $table->foreign('artigo_id')->references('id')->on('artigos')->onDelete('no action');
            $table->foreign('imposto_id')->references('id')->on('impostos')->onDelete('no action');
            $table->foreign('retencao_id')->references('id')->on('retencaos')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('items');
    }
}