<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpostosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impostos', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('tipo')->nullable();
            $table->string('codigo')->nullable();
            $table->string('designacao')->nullable();
            $table->double('taxa')->nullable();
            $table->string('motivo')->nullable();
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
        Schema::dropIfExists('impostos');
    }
}
