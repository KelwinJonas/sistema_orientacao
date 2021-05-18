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
                                <p class="style_pessoas_titulo">Pessoas</p>
                            </div>

                            <!-- Só o proprietario pode add pessoas -->
                            @if($atividade->user_logado_proprietario())
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
                                <div>{{$atividadeUsuario->dono->name}} <span style="color: #909090; font-size: 13px;"> - {{$atividadeUsuario->data_hora_adicionado()}}</span></div>
                            </div>
                            @if($atividade->user_logado_proprietario() && $atividadeUsuario->user_id != Auth::id())
                            <div id="btn_opcoes_pessoas_{{$atividadeUsuario->id}}" class="col-1" style="text-align: right; margin-top: 10px; cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('images/logo_more.png')}}" alt="Opções" width="4px">
                            </div>

                            <div class="dropdown-menu" aria-labelledby="btn_opcoes_pessoas_{{$atividadeUsuario->id}}">
                                <button type="button" class="dropdown-item btn" onclick="$('#modal_editar_pessoa_{{$atividadeUsuario->id}}').modal('show')">Editar papel</button>
                                <button type="button" class="dropdown-item btn btn-danger" style="color: red;" onclick="if(confirm('Tem certza?')) {document.getElementById('remover_membro_{{$atividadeUsuario->id}}').submit();}">Remover pessoa</button>
                            </div>




                            <div id="modal_editar_pessoa_{{$atividadeUsuario->id}}" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h5 class="modal-title" id="header-modal-criar-atividade">Editar pessoa</h5>
                                            <hr>
                                            <form action="{{route('verAtividade.salvarEditarPessoa', $atividade->id)}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="atividade_usuario_id" value="{{$atividadeUsuario->id}}" />
                                                <div class="form-group">
                                                    <label>{{$atividadeUsuario->dono->name}}</label>
                                                    <br>
                                                    <label>{{$atividadeUsuario->dono->email}}</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="papel">Papel</label>
                                                    <select class="form-control campos-cadastro @error('papel') is-invalid @enderror" name='papel' id='papel' value="{{old('papel')}}">
                                                        @foreach(App\Models\Papel::PAPEIS as $nome_bonito => $papel)
                                                        <option value="{{$papel}}" @if($papel==$atividadeUsuario->papel->nome) selected @endif>{{$nome_bonito}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('papel')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </span>
                                                    @enderror
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








                            <form id="remover_membro_{{$atividadeUsuario->id}}" method="POST" action="{{route('verAtividade.removerPessoa', $atividade->id)}}">
                                @csrf
                                <input type="hidden" name="id_membro" value="{{$atividadeUsuario->id}}" />
                            </form>

                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
