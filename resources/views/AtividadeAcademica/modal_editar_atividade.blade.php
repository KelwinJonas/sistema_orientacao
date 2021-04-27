{{-- Modal editar atividade --}}

<div id="modal-editar-atividade-{{$atividadeUsuario->atividadeAcademica->id}}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="header-modal-criar-atividade">Editar atividade</h5>
                <hr>
                <form action="{{route('salvarEditarAtividade', ['atividade_id' => $atividadeUsuario->atividadeAcademica->id])}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tipo">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('tipo') is-invalid @enderror" placeholder="Digite o tipo" name='tipo' id='tipo' value="{{$atividadeUsuario->atividadeAcademica->tipo}}" />
                        @error('tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="titulo">Título <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder="Digite o titulo" name='titulo' id='titulo' value="{{$atividadeUsuario->atividadeAcademica->titulo}}" />
                        @error('titulo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <textarea name="descricao" id="descricao" class="form-control campos-cadastro @error('descricao') is-invalid @enderror" cols="30" rows="8" placeholder="Digite uma descrição">{{$atividadeUsuario->atividadeAcademica->descricao}}</textarea>
                        @error('descricao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="data_inicio">Data início <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='date' class="form-control campos-cadastro @error('data_inicio') is-invalid @enderror" name='data_inicio' id='data_inicio' value="{{$atividadeUsuario->atividadeAcademica->data_inicio}}" />
                        @error('data_inicio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="data_fim">Data fim <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='date' class="form-control campos-cadastro @error('data_fim') is-invalid @enderror" name='data_fim' id='data_fim' value="{{$atividadeUsuario->atividadeAcademica->data_fim}}" />
                        @error('data_fim')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cor_card">Cor do card <span class="cor-obrigatorio">(opcional)</span></label>
                        <div class="container custom-radios">
                            <div class="row justify-content-center">
                                @for($i = 1; $i <= sizeof(\App\Models\AtividadeAcademica::CORES); $i++)
                                <div>
                                    <input type="radio" class="radio-cor-{{$i}}" id="radio-cor-{{$i}}-{{$atividadeUsuario->atividadeAcademica->id}}" name="cor_card" value="{{\App\Models\AtividadeAcademica::CORES[$i-1]}}" />
                                    <label class="label-radio" for="radio-cor-{{$i}}-{{$atividadeUsuario->atividadeAcademica->id}}"><span class="span-radio" style="background-color: {{\App\Models\AtividadeAcademica::CORES[$i-1]}};"></span></label>
                                </div>
                                @endfor
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
