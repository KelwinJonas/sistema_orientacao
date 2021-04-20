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
            $table->string('legenda');
            $table->double('ordem')->default(10000.0); // TEM que ser diferente de 0, e quanto maior, melhor

            $table->unsignedBigInteger('atividade_academica_id');
            $table->foreign('atividade_academica_id')->references('id')->on('atividade_academicas')->onDelete('cascade');

            $table->unsignedBigInteger('secao_id')->nullable(true);
            $table->foreign('secao_id')->references('id')->on('secaos');

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
