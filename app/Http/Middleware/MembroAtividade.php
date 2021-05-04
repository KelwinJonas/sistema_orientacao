<?php

namespace App\Http\Middleware;

use App\Models\AtividadeAcademica;
use Closure;
use Illuminate\Http\Request;

class MembroAtividade
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $atividade_id = explode('/', $request->getRequestUri())[2];
        $atividade = AtividadeAcademica::find($atividade_id);
        if ($atividade && $atividade->user_logado_leitor_ou_acima()) {
            return $next($request);
        }
        return redirect()->route('listarAtividades');
    }
}
