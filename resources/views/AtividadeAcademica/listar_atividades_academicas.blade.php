@extends('layouts.app')

@section('content')
    <div class="container-main">
        <div class="container">
            <div id="div-lista-de-atividades">
                <hr>
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
                                        <div class="col-md-12 div-titulo-card">
                                            <a class="link-titulo-atividade" href="{{route('verAtividade.verMural', ['atividade_id' => $atividadeUsuario->atividadeAcademica->id])}}">{{$atividadeUsuario->atividadeAcademica->titulo}}</a>
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
    {{-- <br>
    <h2>Minhas atividades</h2>

    <div style="overflow: auto; height: 450px">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="">Título</th>
                    <th scope="col" class="">Tipo da atividade</th>
                    <th scope="col" class="">Data início</th>
                    <th scope="col" class="">Data fim</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atividades as $atividade)
                    <tr class='atividade'>
                        <td class='titulo'><a href="{{route('verAtividade', ['atividade_id' => $atividade->id])}}">{{$atividade->titulo}}</a></td>
                        <td class='tipo'>{{$atividade->tipo}}</td>
                        <td class='data_inicio'>{{$atividade->data_inicio}}</td>
                        <td class='data_fim'>{{$atividade->data_fim}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
@endsection