@extends('layouts.app')

@section('content')
    <div class="container-main">
        <div class="container">
            <div id="div-lista-de-atividades">
                <div class="row">
                    <div class="col-md-9" id="cabecalho-listar-atividades"> Minhas atividades</div>
                    <div class="col-md-3"><button class="btn btn-primary" id="botao-criar-atividade" data-toggle="modal" data-target="#modal-criar-atividade">Criar atividade</button></div>
                    <hr>
                </div>
                <hr>
                <div class="row">
                    {{-- Tela modal para criar uma atividade --}}
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
                                            <input type='text' class="form-control campos-cadastro @error('tipo') is-invalid @enderror" placeholder = "Digite o tipo" name='tipo' id='tipo' value="{{old('tipo')}}"/>    
                                            @error('tipo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="titulo">Título <span class="cor-obrigatorio">(obrigatório)</span></label>
                                            <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder = "Digite o titulo" name='titulo' id='titulo' value="{{old('titulo')}}"/>    
                                            @error('titulo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="descricao">Descrição <span class="cor-obrigatorio">(obrigatório)</span></label>
                                            <textarea name="descricao" id="descricao" class="form-control campos-cadastro @error('descricao') is-invalid @enderror" cols="30" rows="8"></textarea>
                                            {{-- <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder = "Digite o titulo" name='titulo' id='titulo' value="{{old('titulo')}}"/>     --}}
                                            @error('descricao')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="data_inicio">Data início <span class="cor-obrigatorio">(obrigatório)</span></label>
                                            <input type='date' class="form-control campos-cadastro @error('data_inicio') is-invalid @enderror" name='data_inicio' id='data_inicio' value="{{old('data_inicio')}}"/>    
                                            @error('data_inicio')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="data_fim">Data fim <span class="cor-obrigatorio">(obrigatório)</span></label>
                                            <input type='date' class="form-control campos-cadastro @error('data_fim') is-invalid @enderror" name='data_fim' id='data_fim' value="{{old('data_fim')}}"/>    
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
                    @if (count($atividadesUsuario) == 0)
                        <div class="col-md-12" id="div-nenhuma-atividade">
                            Nenhuma atividade cadastrada
                        </div>
                    @else
                        @foreach ($atividadesUsuario as $atividadeUsuario)
                        
                            <div class="style_card_tema" style="background-color: {{$atividadeUsuario->atividadeAcademica->cor_card}}">
                                <div class="container div-conteudo-card">
                                    <div class="row">
                                        <div class="col-md-10 div-titulo-card">
                                            <a class="link-titulo-atividade" href="{{route('verAtividade.verMural', ['atividade_id' => $atividadeUsuario->atividadeAcademica->id])}}">{{$atividadeUsuario->atividadeAcademica->titulo}}</a>
                                        </div>
                                        <div class="col-md-2">
                                            
                                            {{-- Permissões - mostrar o botão more--}}
                                            @if ((($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "proprietario")) || (($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "editor")))
                                                <a class="link-imagem-editar-card" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="col-md-12">
                                                        <img class="imagem-editar-card" src="{{asset('images/logo_more.png')}}" alt="">
                                                    </div>
                                                </a> 
                                            @endif
                                            
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
                                                                    <input type='text' class="form-control campos-cadastro @error('tipo') is-invalid @enderror" placeholder = "Digite o tipo" name='tipo' id='tipo' value="{{$atividadeUsuario->atividadeAcademica->tipo}}"/>    
                                                                    @error('tipo')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{$message}}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="titulo">Título <span class="cor-obrigatorio">(obrigatório)</span></label>
                                                                    <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder = "Digite o titulo" name='titulo' id='titulo' value="{{$atividadeUsuario->atividadeAcademica->titulo}}"/>    
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
                                                                    <input type='date' class="form-control campos-cadastro @error('data_inicio') is-invalid @enderror" name='data_inicio' id='data_inicio' value="{{$atividadeUsuario->atividadeAcademica->data_inicio}}"/>    
                                                                    @error('data_inicio')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{$message}}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="data_fim">Data fim <span class="cor-obrigatorio">(obrigatório)</span></label>
                                                                    <input type='date' class="form-control campos-cadastro @error('data_fim') is-invalid @enderror" name='data_fim' id='data_fim' value="{{$atividadeUsuario->atividadeAcademica->data_fim}}"/>    
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
                                                                                <input type="radio" id="radio-cor-1" name="cor_card" value="#2ecc71"/>
                                                                                <label class="label-radio" for="radio-cor-1"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-2" name="cor_card" value="#3498db"/>
                                                                                <label class="label-radio" for="radio-cor-2"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-3" name="cor_card" value="#f1c40f"/>
                                                                                <label class="label-radio" for="radio-cor-3"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-4" name="cor_card" value="#e74c3c"/>
                                                                                <label class="label-radio" for="radio-cor-4"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-5" name="cor_card" value="#836FFF"/>
                                                                                <label class="label-radio" for="radio-cor-5"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-6" name="cor_card" value="#708090"/>
                                                                                <label class="label-radio" for="radio-cor-6"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-7" name="cor_card" value="#808000"/>
                                                                                <label class="label-radio" for="radio-cor-7"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-8" name="cor_card" value="#BC8F8F"/>
                                                                                <label class="label-radio" for="radio-cor-8"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-9" name="cor_card" value="#FF1493"/>
                                                                                <label class="label-radio" for="radio-cor-9"><span class="span-radio"></span></label>
                                                                            </div>
                                                                            <div>
                                                                                <input type="radio" id="radio-cor-10" name="cor_card" value="#7CFC00"/>
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
                                            {{-- Modal deletar atividade --}}
                                            <div id="modal-deletar-atividade-{{$atividadeUsuario->atividadeAcademica->id}}" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            deletar
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-menu card-drop" aria-labelledby="navbarDropdown">
                                                @if((($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "proprietario")))
                                                    <button class="dropdown-item botao-more-card" data-toggle="modal" data-target="#modal-editar-atividade-{{$atividadeUsuario->atividadeAcademica->id}}">Editar</button>
                                                    <button class="dropdown-item botao-more-card" data-toggle="modal" data-target="#modal-deletar-atividade">Deletar</button>
                                                @elseif((($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "editor")))
                                                    <button class="dropdown-item botao-more-card" data-toggle="modal" data-target="#modal-editar-atividade-{{$atividadeUsuario->atividadeAcademica->id}}">Editar</button>
                                                @endif 
                                            </div>
                                        </div>
                                        <div class="col-md-12 div-descricao-card">
                                            @php
                                                $stringExemplo = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a";
                                                if(strlen($atividadeUsuario->atividadeAcademica->descricao) > strlen($stringExemplo)){
                                                    $atividadeUsuario->atividadeAcademica->descricao = mb_strimwidth($atividadeUsuario->atividadeAcademica->descricao, 0, strlen($stringExemplo), "...");
                                                }
                                            @endphp
                                            {{$atividadeUsuario->atividadeAcademica->descricao}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12 div-usuario">
                                        <img src="{{asset('images/logo_user_default.png')}}" alt="Orientação" width="35px"> 
                                        @php
                                            //dd($atividadeUsuario->dono->name);
                                        @endphp
                                        <span id="span-nome-proprietario">{{$atividadeUsuario->dono->name}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection