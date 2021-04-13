<div class="row">
    <div class="col-md-12">

        @foreach($campo->anotacoes as $anotacao)
            <div id="anotacao_{{$anotacao->id}}" class="row">
                <div class="col-md-12">
                    <a href=""
                       onclick="deletar_anotacao({{$anotacao->id}}); return false;"
                    >
                        Deletar
                    </a>
                    {{$anotacao->created_at}} - {{$anotacao->autor->name}} : {{$anotacao->comentario}}
                </div>
            </div>

            <form id="form_deletar_anotacao_{{$anotacao->id}}"
                  action="{{route('anotacoes.deletar')}}"
                  method="POST"
                  class="d-none"
            >
                @csrf
                <input type="hidden" name="anotacao_id" value="{{$anotacao->id}}" />
            </form>
        @endforeach
        
    </div>
</div>
<hr>
