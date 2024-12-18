<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->text('descricao');
            $table->enum('status', ['Pendente', 'Em Andamento', 'Resolvido'])->default('Pendente');
            $table->foreignId('criador_id');
            $table->foreignId('executor_id')->nullable();
            $table->foreign('criador_id')->references('id')->on('users');
            $table->foreign('executor_id')->references('id')->on('users');
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
        Schema::dropIfExists('bugs');
    }
}
