<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papel', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('atividade_usuario_id');
            $table->foreign('atividade_usuario_id')->references('id')->on('atividade_usuario');
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
        Schema::dropIfExists('papel');
    }
}
