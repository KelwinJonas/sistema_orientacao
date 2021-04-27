<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('file_id');//Google drive file_id
            $table->string('parent_id');//Google drive parant_id
            //Acrescentar os outros campos
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
        Schema::dropIfExists('arquivo');
    }
}
