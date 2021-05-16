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
            @include('AtividadeAcademica.modal_criar_atividade')
            @if (count($atividadesUsuario) == 0)
            <div class="col-md-12" id="div-nenhuma-atividade">
                Nenhuma atividade cadastrada
            </div>
            @else
            @foreach ($atividadesUsuario as $atividadeUsuario)
            <div class="style_card_tema" style="background-color: {{$atividadeUsuario->atividadeAcademica->cor_card}}">
                <div class="col-md-2 botao_more">
                    {{-- Permissões - mostrar o botão more--}}
                    @if ((($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "proprietario")) || (($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "editor")))
                    <a class="link-imagem-editar-card" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="col-md-12">
                            <img class="imagem-editar-card" src="{{asset('images/logo_more.png')}}" alt="">
                        </div>
                    </a>
                    @endif

                    @include('AtividadeAcademica.modal_editar_atividade')

                    @if($atividadeUsuario->atividadeAcademica->user_logado_proprietario())
                    <!-- TODO: rota de deletar, deletar mesmo? -->
                    <form action="{{route('deletarAtividade')}}" class="d-none" method="POST" id="form_deletar_atividade_{{$atividadeUsuario->atividadeAcademica->id}}">
                        @csrf
                        <input type="hidden" name="atividade_id" value="{{$atividadeUsuario->atividadeAcademica->id}}">
                    </form>
                    @endif

                    <div class="dropdown-menu card-drop" aria-labelledby="navbarDropdown">
                        @if((($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "proprietario")))
                        <button class="dropdown-item botao-more-card" data-toggle="modal" data-target="#modal-editar-atividade-{{$atividadeUsuario->atividadeAcademica->id}}">Editar</button>
                        <button class="dropdown-item botao-more-card btn-danger" onclick="confirm('Tem certeza que quer apagar esta atividade e tudo referente a ela?') && document.getElementById('form_deletar_atividade_{{$atividadeUsuario->atividadeAcademica->id}}').submit()">Deletar</button>
                        @elseif((($usuarioLogado->id == $atividadeUsuario->user_id) && ($atividadeUsuario->papel->nome == "editor")))
                        <button class="dropdown-item botao-more-card" data-toggle="modal" data-target="#modal-editar-atividade-{{$atividadeUsuario->atividadeAcademica->id}}">Editar</button>
                        @endif
                    </div>
                </div>

                <div class="container div-conteudo-card" onclick="this.getElementsByClassName('link-titulo-atividade')[0].click();">
                    <div class="row">
                        <div class="col-md-10 div-titulo-card">
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
                        <span id="span-nome-proprietario">{{$atividadeUsuario->atividadeAcademica->dono->name}}</span>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
