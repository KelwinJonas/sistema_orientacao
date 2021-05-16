@extends('layouts.app')
@section('content')


<script src="{{ asset('/js/ckeditor.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function recarregar_arvore_secoes(callback) {

        let uso = (texto) => {
            document.getElementById('container_secoes').innerHTML = texto;
        };

        let url = "{{route('arvoreSecoes', [$atividade->id, $secao->id ?? 0])}}";
        fetch(url)
            .then(function(response) {
                return response.text();
            })
            .then(function(texto) {
                uso(texto);
                callback();
            })
            .catch(function(erro) {
                console.log(erro);
            });
    }

    function buscar_anotacoes_js(id_campo, callback_uso) {
        let url = "{{route('anotacoes', '')}}/" + id_campo;
        fetch(url)
            .then(function(response) {
                return response.text();
            })
            .then(function(texto) {
                callback_uso(texto);
            })
            .catch(function(error) {
                console.log("Campo " + id_campo + ", Erro para conseguir as anotações: " + error);
                callback_uso("");
            });

    }
</script>
<script src="{{ asset('/js/funcoes_secoes.js') }}"></script>
<script src="{{ asset('/js/funcoes_secoes_template.js') }}"></script>




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
                            <a class="link-menu-ver-atividade link-menu-selecionado" href="{{route('verAtividade.verSecoes', ['atividade_id' => $atividade->id])}}">Seções</a>
                            <a class="link-menu-ver-atividade" href="{{route('verAtividade.verArquivos', ['atividade_id' => $atividade->id])}}">Arquivos</a>
                            <a class="link-menu-ver-atividade" href="{{route('verAtividade.verPessoas', ['atividade_id' => $atividade->id])}}">Pessoas</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="row" style="padding: 5px;">
                    <div class="col-md-12 style_card_secoes">
                        <div class="row">
                            <div class="col-md-12 style_card_secoes_titulo">
                                <div class="row">
                                    <div class="col">Seções</div>
                                    @if($atividade->user_logado_gerente_ou_acima())
                                    <a class="col" id="botao-criar-secao" data-toggle="modal" data-target="#modal-criar-secao" style="text-align:right; font-size: 15px;" onclick="add_id_na_subsecao(null)">Criar</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12" style="color: #909090;">
                                <div id="container_secoes" class="row">
                                    @include('AtividadeAcademica.secao.arvore_secoes')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deve ser nessa ordem, pra o input e erros de um não interferir no outro  -->

            @if($atividade->user_logado_gerente_ou_acima())
            @if(session("localizacao_erro") == "editar" && isset($secao))
            @include('AtividadeAcademica.secao.modal_editar_secao')
            <script>
                $("#modal-editar-secao").modal("show");
            </script>
            @php session()->put('_old_input', []); @endphp
            @endif

            @include('AtividadeAcademica.secao.modal_criar_secao')

            @if(session("localizacao_erro") == "criar")
            <script>
                document.getElementById("botao-criar-secao").click();
            </script>
            @php session()->put('_old_input', []); @endphp
            @endif
            @endif


            @if(isset($secao))
            @if($atividade->user_logado_gerente_ou_acima())
            @if(session("localizacao_erro") != "editar")
            @include('AtividadeAcademica.secao.modal_editar_secao')
            @endif
            @endif
            <div class="col-md-7">
                <div class="row" style="padding: 5px;">
                    <div class="col-md-12 style_secao" style="display: inline; padding-top: 5px; padding-bottom: 5px;" id="id_area_secao">

                        <span style="position: relative; top: 10px;">{{$secao->nome}}</span>

                        <button id="btn_dropdown_opcoes_secao" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" @if(!$atividade->user_logado_gerente_ou_acima()) style="visibility: hidden;" @endif class="btn dropdown-toggle">⠇</button>

                        @if($atividade->user_logado_gerente_ou_acima())
                        <div class="dropdown-menu" aria-labelledby="btn_dropdown_opcoes_secao">
                            <button type="button" data-toggle="modal" data-target="#modal-criar-secao" onclick="add_id_na_subsecao({{$secao->id}})" class="dropdown-item">Adicionar Subseção</button>
                            <button type="button" class="dropdown-item" onclick="abrir_fechar_add_campo(true);">Adicionar Campo</button>
                            <hr style="width: 85%;">
                            <button type="button" data-toggle="modal" data-target="#modal-editar-secao" onclick="add_id_na_subsecao(null)" class="dropdown-item">Editar Seção</button>
                            @if($atividade->user_logado_proprietario())
                            <button type="button" class="dropdown-item btn btn-danger" style="color: red;" onclick="event.preventDefault(); (confirm('Tem certeza que quer apagar esta seção e tudo referente a ela?') && document.getElementById('deletar_secao_form').submit());">Deletar Seção</button>

                            <form id="deletar_secao_form" action="{{ route('deletarSecao') }}" method="POST" class="d-none">
                                @csrf
                                <input type="hidden" name="secao_id" value="{{$secao->id}}" />
                            </form>
                            @endif
                        </div>
                        @endif
                    </div>


                    @if($atividade->user_logado_gerente_ou_acima())
                    <div class="col-md-12 style_secao_ativo" style="display: none;" id="id_area_secao_texto">
                        <form action="{{route('salvarCampo')}}" method="POST">
                            @csrf
                            <input type="hidden" name="secao_id" id="campo_secao_id" value="{{$secao->id}}">
                            <input type="hidden" name="campo_id" id="campo_id">
                            <div class="form-group">
                                <div style="float: left;">
                                    <label for="titulo" style="margin-top: 5px; font-weight: 600; color: #909090;">Campo</label>
                                </div>
                                <div style="float: right;">
                                    <button type="button" class="btn btn-light" style="margin-top: -5px;margin-bottom: 7px;" onclick="abrir_fechar_add_campo(false)">
                                        <div width="16px" style="margin-top: -4px;">✖</div>
                                    </button>
                                </div>
                                <input type="text" class="form-control" id="titulo" placeholder="Escreva o titulo do campo." name="titulo" />
                                <br>
                                <input type="text" class="form-control" id="legenda_campo" placeholder="Escreva uma legenda para o campo." name="legenda" />
                                @if(session("localizacao_erro") == "salvar_campo")
                                @if ($errors->any())
                                <script>
                                    $(document).ready(function() {
                                        abrir_fechar_add_campo(true);
                                        document.getElementById('titulo').value = "{{session('titulo_old')}}";
                                        document.getElementById('legenda_campo').value = "{{session('legenda_old')}}";
                                    });
                                </script>
                                <br>
                                <div id="erro_campo" class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @endif
                            </div>
                            <div style="float: right;">
                                <button type="button" class="btn btn-light" onclick="abrir_fechar_add_campo(false)">Cancelar</button>
                                <button id="btn_salvar_campo" type="submit" class="btn btn-success">Adicionar</button>
                            </div>
                        </form>
                    </div>
                    @endif



                    <!-- iterator de campo -->
                    @foreach($secao->campos as $campo)
                    <div class="col-md-12 style_card_secoes_atividade">
                        <div class="row">
                            <div id="div_titulo_campo_{{$campo->id}}" class="col" style=" width: 100%; text-align: center; cursor: pointer;">
                                {{$campo->titulo}}
                            </div>
                            <div class="col-1" style="text-align: right; right: 24px;">
                                <button id="btn_dropdown_opcoes_campo_{{$campo->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" class="btn btn-light dropdown-toggle" style="margin-top: -5px;margin-bottom: 7px;@if(!$atividade->user_logado_gerente_ou_acima())visibility: hidden;@endif" onclick="abrir_fechar_add_campo(false)">
                                    <div width="4px">⠇</div>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btn_dropdown_opcoes_campo_{{$campo->id}}">
                                    <button type="button" class="dropdown-item" onclick="editar_campo('{{$campo->id}}', '{{$campo->titulo_escapado()}}', '{{$campo->legenda_escapada()}}')">Editar informações do Campo</button>
                                    <button type="button" class="dropdown-item btn btn-danger" onclick="confirm('Tem certeza que quer apagar este campo e todo seu conteúdo?') && document.getElementById('form_deletar_campo_{{$campo->id}}').submit()">Deletar Campo</button>
                                </div>


                                @if($atividade->user_logado_gerente_ou_acima())
                                <form id="form_deletar_campo_{{$campo->id}}" method="POST" action="{{ route('deletarCampo') }}" class="d-none">
                                    @csrf
                                    <input type="hidden" name="campo_id" value="{{$campo->id}}">
                                </form>
                                @endif

                            </div>
                        </div>

                        <div id="conteudo_campo_{{$campo->id}}" class="collapse col-md-12">
                            <hr>
                            <div class="row">
                                <div class="col text-center">
                                    {{$campo->legenda}}
                                </div>
                            </div>
                            <hr>

                            @if($atividade->user_logado_editor_ou_acima())
                            <form action="{{ route('salvarConteudo') }}" method="POST">
                                @csrf
                                @endif
                                <input type="hidden" name="id_campo" value="{{$campo->id}}" />
                                <textarea id="editor_campo_{{$campo->id}}" name="conteudo">
                                {{ $campo->conteudo }}
                                </textarea>
                                @if($atividade->user_logado_editor_ou_acima())
                                <button class="btn btn-success" style="margin-top: 10px; width: 100%;" type="submit">Salvar</button>
                            </form>
                            @endif
                            <hr>

                            <div id="anotacoes_campo_{{$campo->id}}"></div>

                            <script>
                                ClassicEditor
                                    .create(document.querySelector("#editor_campo_{{$campo->id}}"))
                                    .then((editor) => {
                                        @if(!$atividade->user_logado_editor_ou_acima())
                                        editor.isReadOnly = true;
                                        @endif
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });

                                buscar_anotacoes_js("{{$campo->id}}", function(texto) {
                                    document.getElementById("anotacoes_campo_{{$campo->id}}").innerHTML = texto;
                                });
                            </script>


                            @if($atividade->user_logado_leitor_ou_acima())
                            <form id="form_enviar_anotacao_{{$campo->id}}" method="POST" onsubmit="enviar_anotacao(this, anotacoes_campo_{{$campo->id}}, {{$campo->id}}); return false;" action="{{ route('anotacoes.salvar') }}">
                                @csrf
                                <input type="hidden" name="campo_id" value="{{$campo->id}}" />
                                <div class="form-group">
                                    <input class="form-control" style="display: inline-block; width: 85%;" type="text" placeholder="Comente algo sobre o campo" name="comentario" />
                                    <input name="btn_salvar_campo" class="btn btn-success comentario_campo" style="margin-top: -4px" type="submit" value="->" />
                                </div>
                            </form>
                            @endif
                            <br>


                        </div>
                    </div>

                    <button id="btn_conteudo_campo_{{$campo->id}}" class="btn d-none" type="button" data-toggle="collapse" data-target="#conteudo_campo_{{$campo->id}}" aria-expanded="false" aria-controls="conteudo_campo_{{$campo->id}}"></button>

                    <script>
                        document.getElementById("div_titulo_campo_{{$campo->id}}").onclick = function() {
                            document.getElementById("btn_conteudo_campo_{{$campo->id}}").click();
                        };
                    </script>

                    @endforeach
                </div>
            </div>
            @else
            <div class="col-md-7"></div>
            @endif
        </div>
    </div>
</div>



@if($atividade->user_logado_gerente_ou_acima())
<form action="{{route('editarOrdemSecao')}}" method="POST" class="d-none" id="form_ordenar_secao">
    @csrf
    <input type="hidden" id="id_irmao_ante" name="id_irmao_ante" value="0">
    <input type="hidden" id="id_irmao_post" name="id_irmao_post" value="0">
    <input type="hidden" id="id_secao_arrastada" name="id_secao_arrastada" value="0">
</form>


<form action="{{route('subsecionarSecao')}}" method="POST" class="d-none" id="form_subsecionar_secao">
    @csrf
    <input type="hidden" id="id_secao_arrastada_que_vai_entrar" name="id_secao_arrastada_que_vai_entrar" value="0">
    <input type="hidden" id="id_secao_alvo" name="id_secao_alvo" value="0">
</form>
@endif
@endsection
