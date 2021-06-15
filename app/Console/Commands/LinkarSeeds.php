<?php

namespace App\Console\Commands;

use App\Models\AtividadeUsuario;
use App\Models\Papel;
use App\Models\User;
use Illuminate\Console\Command;

class LinkarSeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:linkar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atribui o novo usuario ao que já foi criado no seed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id_novo_user = User::all()->last()->id;
        $atividade_user = new AtividadeUsuario;
        $atividade_user->user_id = $id_novo_user;
        $atividade_user->atividade_academica_id = 1;
        $atividade_user->save();
        $papel_user = new Papel;
        $papel_user->nome = Papel::PROPRIETARIO;
        $papel_user->atividade_usuario_id = $atividade_user->id;
        $user = User::find($id_novo_user);
        $user->gerente_instituicoes = true;
        $user->save();
        $papel_user->save();
        return 0;
    }
}
