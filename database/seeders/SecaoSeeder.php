<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secaos')->insert([
            'tipo' => 'tipo',
            'nome' => 'Seção 1',
            'ordem' => 1,
            'atividade_academica_id' => 1,
            'secao_id' => null,
        ]);

        DB::table('secaos')->insert([
            'tipo' => 'tipo',
            'nome' => 'Subseção 1',
            'ordem' => 2,
            'atividade_academica_id' => 1,
            'secao_id' => 1,
        ]);

        DB::table('campos')->insert([
            'titulo' => 'Campo 1',
            'legenda' => 'Legenda do campo 1',
            'conteudo' => '<p>Um paragrafo</p>',
            'secao_id' => 2,
        ]);

        DB::table('secaos')->insert([
            'tipo' => 'tipo',
            'nome' => 'Seção 2',
            'ordem' => 3,
            'atividade_academica_id' => 1,
            'secao_id' => null,
        ]);

        DB::table('campos')->insert([
            'titulo' => 'Campo 2',
            'legenda' => 'Legenda do campo 2',
            'conteudo' => '<p>Outro paragrafo</p>',
            'secao_id' => 3,
        ]);

        DB::table('anotacaos')->insert([
            'comentario' => 'Comentado',
            'status' => true,
            'campo_id' => 2,
            'user_id' => 1,
        ]);
        
    }
}
