<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecaoController extends Controller
{
    public function salvarAdicionarSecao(Request $request){
        $entrada = $request->all();
        dd($entrada);
    }
}
