<?php

namespace Database\Seeders;

use App\Models\Papel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('atividade_academicas')->insert([
            'tipo' => "Tipo da atividade",
            'titulo' => 'Atividade exemplo',
            'descricao' => 'Atividade criada pra não ter que criar toda vez que mexe no banco de dados',
            'data_inicio' => Carbon::yesterday(),
            'data_fim' => Carbon::tomorrow(),
            'cor_card' => "#F0D882",
            'folder_id' => "none",
            'user_id' => 1,
        ]);


        DB::table('atividade_usuarios')->insert([
            'user_id' => 1,
            'atividade_academica_id' => 1,
        ]);

        DB::table('papels')->insert([
            'atividade_usuario_id' => 1,
            'nome' => Papel::PROPRIETARIO,
        ]);
    }
}
