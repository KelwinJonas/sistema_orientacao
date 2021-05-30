@extends('layouts.app')
@section('content')
    <div class="container-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="row align-items-start">
                                <div class="col" style=" width: 100%;">
                                    <p class="style_pessoas_titulo">Instituições</p>
                                </div>
                                @include('Instituicao.modal_nova_instituicao')
                                <div class="col" style="text-align: right;">
                                    <a href="#" data-toggle="modal" data-target="#modal-criar-instituicao" class="btn btn-primary btn-sm" style="margin-top: 5px;">Adicionar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="background-color: black; margin-top: -10px; height: 2px; margin-left: -15px; margin-right:-15px">
                        </div>
                        @foreach ($instituicoes as $instituicao)
                            <div class="col-md-12 style_card_pessoas_atividade">
                                <div class="row align-items-start">
                                    <div style="width: 40px;margin-left:15px; margin-bottom:15px;">
                                        <img src="{{asset('images/logo_novo_user.png')}}" alt="Orientação" width="40px">
                                    </div>
                                    <div class="col link_instituicao" style="width: 100%; margin-top: 10px;" onclick="document.location = '{{route('instituicao.ver', $instituicao->id)}}'">
                                        <div>{{$instituicao->nome}} <span style="color: #909090; font-size: 13px;"></span></div>
                                    </div>
                                    <div id="btn_opcoes_instituicoes_{{$instituicao->id}}" class="col-1" style="text-align: right; margin-top: 10px; cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{asset('images/logo_more.png')}}" alt="Opções" width="4px">
                                    </div>
                                    <div class="dropdown-menu" aria-labelledby="btn_opcoes_instituicoes_{{$instituicao->id}}">
                                        <button type="button" class="dropdown-item btn" onclick="$('#modal_editar_instituicao_{{$instituicao->id}}').modal('show')">Editar</button>
                                        <button type="button" class="dropdown-item btn btn-danger" style="color: red;" onclick="confirm('Tem certeza que quer apagar essa instituição?') && document.getElementById('form_deletar_instituicao_{{$instituicao->id}}').submit();"  >Deletar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal_editar_instituicao_{{$instituicao->id}}" tabindex="-1" role="dialog" aria-labelledby="add_template_label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="add_template_label">Editar {{$instituicao->nome}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('instituicao.editar.salvar')}}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$instituicao->id}}" name="instituicao_id" />
                                                <div class="form-group">
                                                    <label for="titulo">Titulo <span class="cor-obrigatorio">(obrigatório)</span></label>
                                                    <input type='text' class="form-control campos-cadastro" placeholder="Digite o nome" name='nome' id='nome' value="{{old('nome', $instituicao->nome)}}" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-success">Salvar</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                            <form method="POST" action="{{route('instituicao.deletar')}}" id="form_deletar_instituicao_{{$instituicao->id}}" class="d-none">
                                @csrf
                                <input type="hidden" name="instituicao_id" value="{{$instituicao->id}}" />
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
