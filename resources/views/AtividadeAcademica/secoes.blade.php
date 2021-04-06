@extends('layouts.app')

@section('content')
    <div class="container-main">
        <div class="container" id="container-ver-atividade">
            <div class="row justify-content-center">
                <div class="col-md-10 style_card_tema_largo" style="background-color: {{$atividade->cor_card}}">
                    <div class="container" id="container-conteudo-ver-atividade">
                        <div class="row">
                        <div class="col-md-12 style_card_container"><p class="style_card_tema_titulo">{{$atividade->titulo}}</p></div>
                        <div class="col-md-12">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</div>
                        </div>
                        <hr>
                        <div class="col-md-12 style_card_menu">
                            <div id="menu-ver-atividade">
                                <a class="link-menu-ver-atividade" href="{{route('verAtividade.verMural', ['atividade_id' => $atividade->id])}}">Mural</a>
                                <a class="link-menu-ver-atividade link-menu-selecionado" href="{{route('verAtividade.verSecoes', ['atividade_id' => $atividade->id])}}">Seções</a>
                                <a class="link-menu-ver-atividade" href="{{route('verAtividade.verArquivos', ['atividade_id' => $atividade->id])}}">Arquivos</a>
                                <a class="link-menu-ver-atividade" href="{{route('verAtividade.verPessoas', ['atividade_id' => $atividade->id])}}">Pessoas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection