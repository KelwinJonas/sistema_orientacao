<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use stdClass;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $secao_1 = new stdClass;
        $subsecao_1 = new stdClass;
        $campo_1 = new stdClass;
        $secao_2 = new stdClass;
        $campo_2 = new stdClass;

        $campo_1->tipo = "campo";
        $campo_1->titulo = "Campo 1";
        $campo_1->filhos = [];

        $campo_2->tipo = "campo";
        $campo_2->titulo = "Campo 2";
        $campo_2->filhos = [];

        $subsecao_1->tipo = "secao";
        $subsecao_1->titulo = "Subseção 1";
        $subsecao_1->filhos = [$campo_1];

        $secao_1->tipo = "secao";
        $secao_1->titulo = "Seção 1";
        $secao_1->filhos = [$subsecao_1];

        $secao_2->tipo = "secao";
        $secao_2->titulo = "Seção 2";
        $secao_2->filhos = [$campo_2];

        $template = [$secao_1, $secao_2];

        DB::table('template_atividades')->insert([
            'tipo' => 'template',
            'titulo' => 'template com seções e campos',
            //TODO: melhorar esse array template usando stdObj
            'arr_template' => json_encode($template),
            'instituicao_id' => 1,
        ]);
    }
}
