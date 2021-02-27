<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secaos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('nome');
            $table->integer('ordem');
            $table->unsignedBigInteger('atividade_academica_id');
            $table->foreign('atividade_academica_id')->references('id')->on('atividade_academicas');
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
        Schema::dropIfExists('secao');
    }
}
