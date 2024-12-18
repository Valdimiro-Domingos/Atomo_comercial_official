<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('designacao');
            $table->string('nif');
            $table->string('registo_comercial')->nullable();
            $table->date('data_fundacao');
            $table->string('csocial')->nullable();
            $table->string('representante');
            $table->string('ndi_rep');
            $table->string('descricao')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('expermental')->nullable();
            $table->date('prazo_inicio')->nullable();
            $table->date('prazo_termino')->nullable();
            $table->string('data_criacao')->nullable();
            $table->string('operador')->nullable();
            $table->foreignId('id_endereco')->nullable();
            $table->foreignId('id_contacto')->nullabled();
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
        Schema::dropIfExists('empresas');
    }
}
