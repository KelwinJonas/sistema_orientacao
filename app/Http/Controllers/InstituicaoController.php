<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstituicaoController extends Controller
{
    public function cadastroInstituicao(){
        return view('Instituicao.cadastrar_instituicao');
    }
}
