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
                                <div>
                                    <input type="radio" id="radio-cor-1" class="" name="cor_card" value="#2ecc71" />
                                    <label class="label-radio" for="radio-cor-1"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-2" name="cor_card" value="#3498db" />
                                    <label class="label-radio" for="radio-cor-2"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-3" name="cor_card" value="#f1c40f" />
                                    <label class="label-radio" for="radio-cor-3"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-4" name="cor_card" value="#e74c3c" />
                                    <label class="label-radio" for="radio-cor-4"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-5" name="cor_card" value="#836FFF" />
                                    <label class="label-radio" for="radio-cor-5"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-6" name="cor_card" value="#708090" />
                                    <label class="label-radio" for="radio-cor-6"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-7" name="cor_card" value="#808000" />
                                    <label class="label-radio" for="radio-cor-7"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-8" name="cor_card" value="#BC8F8F" />
                                    <label class="label-radio" for="radio-cor-8"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-9" name="cor_card" value="#FF1493" />
                                    <label class="label-radio" for="radio-cor-9"><span class="span-radio"></span></label>
                                </div>
                                <div>
                                    <input type="radio" id="radio-cor-10" name="cor_card" value="#7CFC00" />
                                    <label class="label-radio" for="radio-cor-10"><span class="span-radio"></span></label>
                                </div>
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
