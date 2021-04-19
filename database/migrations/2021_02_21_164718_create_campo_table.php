<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->longText('conteudo')->nullable(true);
            $table->unsignedBigInteger('secao_id');
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
        Schema::dropIfExists('campo');
    }
}
