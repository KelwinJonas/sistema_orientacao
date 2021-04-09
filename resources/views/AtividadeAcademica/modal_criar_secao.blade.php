<div id="modal-criar-secao" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="header-modal-criar-atividade">Criar seção</h5>
                <hr>
                <form action="{{route('salvarSecao')}}" method="POST">
                    @csrf

                    <input type='hidden' name='atividade_academica_id' value="{{$atividade->id}}"/>
                    <input type='hidden' name='secao_id' id='secao_id'/>
                    <div class="form-group">
                        <label for="tipo">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('tipo') @if(session("localizacao_erro") == "criar") is-invalid @endif @enderror" placeholder = "Digite o tipo" name='tipo' id='tipo' value="{{old('tipo')}}"/>
                        @error('tipo')
                        @if(session("localizacao_erro") == "criar")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @endif
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="titulo">Nome <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('nome') @if(session("localizacao_erro") == "criar") is-invalid @endif @enderror" placeholder = "Digite o nome" name='nome' id='nome' value="{{old('nome')}}"/>
                        @error('nome')
                        @if(session("localizacao_erro") == "criar")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @endif
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="titulo">Legenda <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('legenda') @if(session("localizacao_erro") == "criar") is-invalid @endif @enderror" placeholder = "Digite a legenda" name='legenda' id='legenda' value="{{old('legenda')}}"/>
                        @error('legenda')
                        @if(session("localizacao_erro") == "criar")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @endif
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="titulo">Posição da seção<span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='number' min="1" class="form-control campos-cadastro @error('ordem') @if(session("localizacao_erro") == "criar") is-invalid @endif @enderror" name='ordem' id='ordem' value="{{old('ordem', 1)}}"/>
                        @error('legenda')
                        @if(session("localizacao_erro") == "criar")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @endif
                        @enderror
                    </div>
                    <hr>
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Criar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
