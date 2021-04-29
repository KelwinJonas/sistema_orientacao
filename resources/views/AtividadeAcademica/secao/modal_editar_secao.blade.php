<div id="modal-editar-secao" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="header-modal-criar-atividade">Editar seção</h5>
                <hr>
                <form action="{{route('salvarEditarSecao')}}" method="POST">
                    @csrf

                    <input type='hidden' name='atividade_academica_id' value="{{$atividade->id}}"/>
                    <input type='hidden' name='id_secao' value="{{$secao->id}}"/>

                    <div class="form-group">
                        <label for="tipo">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('tipo') @if(session("localizacao_erro") == "editar") is-invalid @endif @enderror" placeholder = "Digite o tipo" name='tipo' id='tipo' value="{{old('tipo', $secao->tipo)}}"/>
                        @error('tipo')
                        @if(session("localizacao_erro") == "editar")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @endif
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="titulo">Nome <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('nome') @if(session("localizacao_erro") == "editar") is-invalid @endif @enderror" placeholder = "Digite o nome" name='nome' id='nome' value="{{old('nome', $secao->nome)}}"/>
                        @error('nome')
                        @if(session("localizacao_erro") == "editar")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @endif
                        @enderror
                    </div>
                    <hr>
                    <div class="float-left">
                        <a href="{{route('deletarSecao')}}"
                           onclick="event.preventDefault(); document.getElementById('deletar_secao_form').submit();">
                            <button type="button" class="btn btn-danger">Deletar seção e todas as subseções</button></a>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>

                <form id="deletar_secao_form" action="{{ route('deletarSecao') }}" method="POST" class="d-none">
                    @csrf
                    <input type="hidden" name="secao_id" value="{{$secao->id}}" />
                </form>
                
            </div>
        </div>
    </div>
</div>
