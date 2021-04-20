@extends('layouts.app')

@section('content')
    <div class="container-main">
        <div class="container" id="container-ver-atividade">
            <div class="row justify-content-center">
                <div class="col-md-10 style_card_tema_largo" style="background-color: {{$atividade->cor_card}}">
                    <div class="container" id="container-conteudo-ver-atividade">
                        <div class="row">
                        <div class="col-md-12 style_card_container"><p class="style_card_tema_titulo">{{$atividade->titulo}}</p></div>
                        <div class="col-md-12">{{$atividade->descricao}}</div>
                        </div>
                        <hr>
                        <div class="col-md-12 style_card_menu">
                            <div id="menu-ver-atividade">
                                <a class="link-menu-ver-atividade" href="{{route('verAtividade.verMural', ['atividade_id' => $atividade->id])}}">Mural</a>
                                <a class="link-menu-ver-atividade" href="{{route('verAtividade.verSecoes', ['atividade_id' => $atividade->id])}}">Seções</a>
                                <a class="link-menu-ver-atividade link-menu-selecionado" href="{{route('verAtividade.verArquivos', ['atividade_id' => $atividade->id])}}">Arquivos</a>
                                <a class="link-menu-ver-atividade" href="{{route('verAtividade.verPessoas', ['atividade_id' => $atividade->id])}}">Pessoas</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="modal-adicionar-arquivos" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h5 class="modal-title" id="header-modal-criar-atividade">Adicionar arquivos</h5>
                                <hr>
                                <form action="{{route('uploadArquivo', ['atividade_id' => $atividade->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file" name="arquivo" class="btn btn-primary btn-block">
                                    </div>
                                    <hr>
                                    <div class="float-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Adicionar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row" style="padding: 5px;">
                        <div style="float: left; margin-bottom: 10px;">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('images/logo_clip_branco.png')}}" alt="Opções" width="16px" style="margin-top: -4px;"> Adicionar</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-adicionar-arquivos">Arquivos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
@endsection