<div class="row">
    <div class="col-md-12">

        @if($campo->anotacoes->count() == 0)
        Não há nenhuma anotação aqui...
        @endif

        @foreach($campo->anotacoes as $anotacao)
        <div id="anotacao_{{$anotacao->id}}" class="row">
            <div class="col-md-12">
                @if($campo->secao->atividade->user_logado_editor_propietario())
                <a href="" onclick="deletar_anotacao({{$anotacao->id}}); return false;">
                    Deletar
                </a>
                @endif
                {{$anotacao->created_at}} - {{$anotacao->autor->name}} : {{$anotacao->comentario}}
            </div>
        </div>

        @if($campo->secao->atividade->user_logado_editor_propietario())
        <form id="form_deletar_anotacao_{{$anotacao->id}}" action="{{route('anotacoes.deletar')}}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="anotacao_id" value="{{$anotacao->id}}" />
        </form>
        @endif
        @endforeach

    </div>
</div>
<hr>
