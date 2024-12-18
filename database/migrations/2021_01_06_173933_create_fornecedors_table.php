<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('codigo')->nullable();
            $table->string('designacao')->nullable();
            $table->string('contribuinte')->nullable();
            $table->string('zona')->nullable();
            $table->string('identificacao')->nullable();
            $table->string('observacao')->nullable();
            $table->string('imagem')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('is_used')->nullable();
            $table->foreignId('id_endereco')->nullable();
            $table->foreignId('id_contacto')->nullable();
            $table->foreign('id_endereco')->references('id')->on('enderecos')->onDelete('cascade');
            $table->foreign('id_contacto')->references('id')->on('contactos')->onDelete('cascade');
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
        Schema::dropIfExists('fornecedors');
    }
}
