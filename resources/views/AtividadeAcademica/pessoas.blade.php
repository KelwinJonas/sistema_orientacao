@extends('layouts.app')

@section('content')
<div class="container-main">
    <div class="container" id="container-ver-atividade">
        <div class="row justify-content-center">
            <div class="col-md-10 style_card_tema_largo" style="background-color: {{$atividade->cor_card}}">
                <div class="container" id="container-conteudo-ver-atividade">
                    <div class="row">
                        <div class="col-md-12 style_card_container">
                            <p class="style_card_tema_titulo">{{$atividade->titulo}}</p>
                        </div>
                        <div class="col-md-12">{{$atividade->descricao}}</div>
                    </div>
                    <hr>
                    <div class="col-md-12 style_card_menu">
                        <div id="menu-ver-atividade">
                            <a class="link-menu-ver-atividade" href="{{route('verAtividade.verMural', ['atividade_id' => $atividade->id])}}">Mural</a>
                            <a class="link-menu-ver-atividade" href="{{route('verAtividade.verSecoes', ['atividade_id' => $atividade->id])}}">Seções</a>
                            <a class="link-menu-ver-atividade" href="{{route('verAtividade.verArquivos', ['atividade_id' => $atividade->id])}}">Arquivos</a>
                            <a class="link-menu-ver-atividade link-menu-selecionado" href="{{route('verAtividade.verPessoas', ['atividade_id' => $atividade->id])}}">Pessoas</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Conteudo aqui --}}
            <div class="col-md-10">
                <div class="row" style="padding: 5px;">
                    <div class="col-md-12">
                        <div class="row align-items-start">
                            <div class="col" style=" width: 100%;">
                                <p class="style_pessoas_titulo">Membros</p>
                            </div>

                            @if($atividade->user_logado_pode_pessoas())
                                @include('AtividadeAcademica.modal_add_pessoas')
                                <div class="col" style="text-align: right;">
                                    <button type="button" class="btn btn-primary btn-sm" style="margin-top: 5px;" data-toggle="modal" data-target="#modal-adicionar-pessoa">Adicionar</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr style="background-color: black; margin-top: -10px; height: 2px; margin-left: -15px; margin-right:-15px">
                    </div>
                    @foreach ($atividade->atividadesUsuario as $atividadeUsuario)
                    <div class="col-md-12 style_card_pessoas_atividade">
                        <div class="row align-items-start">
                            <div style="width: 40px;margin-left:15px; margin-bottom:15px;">
                                <img src="{{asset('images/logo_novo_user.png')}}" alt="Orientação" width="40px">
                            </div>
                            <div class="col" style=" width: 100%; margin-top: 10px;">
                                <div>{{$atividadeUsuario->dono->name}} <span style="color: #909090; font-size: 13px;"> - 20/02/2021 as 10h00</span></div>
                            </div>
                            <div class="col-1" style="text-align: right; margin-top: 10px;">
                                <img src="{{asset('images/logo_more.png')}}" alt="Opções" width="4px">
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
