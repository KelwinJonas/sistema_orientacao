{{-- Tela modal para criar uma atividade --}}
<div class="row">
    <div id="modal-criar-atividade" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="header-modal-criar-atividade">Criar atividade</h5>
                    <hr>
                    <form action="{{route('cadastrarAtividade.salvar')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tipo">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='text' class="form-control campos-cadastro @error('tipo') is-invalid @enderror" placeholder="Digite o tipo" name='tipo' id='tipo' value="{{old('tipo')}}" />
                            @error('tipo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="titulo">Título <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder="Digite o titulo" name='titulo' id='titulo' value="{{old('titulo')}}" />
                            @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <textarea name="descricao" id="descricao" class="form-control campos-cadastro @error('descricao') is-invalid @enderror" cols="30" rows="8"></textarea>
                            {{-- <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder = "Digite o titulo" name='titulo' id='titulo' value="{{old('titulo')}}"/> --}}
                            @error('descricao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="data_inicio">Data início <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='date' class="form-control campos-cadastro @error('data_inicio') is-invalid @enderror" name='data_inicio' id='data_inicio' value="{{old('data_inicio')}}" />
                            @error('data_inicio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="data_fim">Data fim <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='date' class="form-control campos-cadastro @error('data_fim') is-invalid @enderror" name='data_fim' id='data_fim' value="{{old('data_fim')}}" />
                            @error('data_fim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                                            <label for="cor_card">Cor do card <span class="cor-obrigatorio">(obrigatório)</span></label>
                                            <input type='color' class="form-control campos-cadastro @error('cor_card') is-invalid @enderror" name='cor_card' id='cor_card' value="{{old('cor_card')}}"/>
                        @error('cor_card')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                </div> --}}
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
