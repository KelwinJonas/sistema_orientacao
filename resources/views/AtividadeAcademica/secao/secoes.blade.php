@extends('layouts.app')
@section('content')


<script src="{{ asset('/js/ckeditor.js') }}"></script>
<script>
    function mostrar_tela_carregamento() {
        console.log("Carregando...");
    }

    function abrir_fechar_add_campo(abrir) { // se abrir for true, abre, se não, fecha
        document.getElementById("id_area_secao").style.display = (abrir ? "none" : "block");
        document.getElementById("id_area_secao_texto").style.display = (abrir ? "block" : "none");
        document.getElementById("campo_id").value = null;
        document.getElementById("titulo").value = "";
        document.getElementById("btn_salvar_campo").innerHTML = "Adicionar";
    }

    function editar_campo(id_campo, titulo_campo) {
        abrir_fechar_add_campo(true);
        document.getElementById("campo_id").value = id_campo;
        document.getElementById("titulo").value = String(titulo_campo).replace("\"", "").split("").reverse().join("").replace("\"", "").split("").reverse().join("");
        document.getElementById("btn_salvar_campo").innerHTML = "Salvar";
    }


    function buscar_anotacoes_js(id_campo, callback_uso) {
        //TODO: mudar isso antes da produção
        let url = "http://127.0.0.1:8000/anotacoes/" + id_campo;
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

    function enviar_anotacao(form, anotacoes, id_campo) {
        //submit
        const XHR = new XMLHttpRequest();
        const FD = new FormData();
        let input_comentario;
        let btn_comentario;

        let urlEncodedDataPairs = [];
        for (let input of form.querySelectorAll("input")) {
            if (input.name === "comentario" && input.value.length < 2) {
                return;
            }
            FD.append(input.name, input.value);
            if (input.name === "comentario") {
                input_comentario = input;
            }
            if (input.name === "btn_salvar_campo") {
                btn_comentario = input;
            }
        }
        btn_comentario.style.display = "none";

        XHR.addEventListener('load', function(event) {
            console.log(event);
            input_comentario.value = "";
            btn_comentario.style.display = "inline-block";
        });

        XHR.addEventListener('error', function(event) {
            alert('Não foi possivel enviar a anotação');
            btn_comentario.style.display = "inline-block";
        });

        XHR.open('POST', form.action);
        XHR.send(FD);

        //baixar anotacoes dnv
        buscar_anotacoes_js(id_campo, function(texto) {
            anotacoes.innerHTML = texto;
        });
    }

    function deletar_anotacao(id) {
        document.getElementById("anotacao_" + id).style.display = "none";
        let form = document.getElementById("form_deletar_anotacao_" + id);

        //submit
        const XHR = new XMLHttpRequest();
        const FD = new FormData();

        let urlEncodedDataPairs = [];
        for (let input of form.querySelectorAll("input")) {
            FD.append(input.name, input.value);
        }

        XHR.open('POST', form.action);
        XHR.send(FD);
    }

    function add_id_na_subsecao(id) {
        document.getElementById("secao_id").value = id;
    }


    /* ClassicEditor.builtinPlugins.map( plugin => console.log(plugin.pluginName) ); */
</script>




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
                                    <a class="col" id="botao-criar-secao" data-toggle="modal" data-target="#modal-criar-secao" style="text-align:right; font-size: 15px;" onclick="add_id_na_subsecao(null)">Criar</a>
                                </div>
                            </div>
                            <div class="col-md-12" style="color: #909090;">
                                <div id="container_secoes" class="row">

                                    @if($atividade->secoes->count() == 0)

                                    <p class="col">
                                        Nenhuma seção criada.
                                        <br>
                                        <a id="botao-criar-secao" data-toggle="modal" data-target="#modal-criar-secao" style="text-align:right; font-size: 15px; color: blue;" onclick="add_id_na_subsecao(null)">
                                            Clique aqui
                                        </a>
                                        para criar uma seção.
                                    </p>
                                    @endif
                                    <!-- TODO: se o nome tiver html, ele pode ser injetado... -->
                                    @foreach($atividade->secoes as $secao_loop)
                                    @php echo $secao_loop->arvore_secoes($secao); @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deve ser nessa ordem, pra o input e erros de um não interferir no outro  -->

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


            @if(isset($secao))
            @if(session("localizacao_erro") != "editar")
            @include('AtividadeAcademica.secao.modal_editar_secao')
            @endif
            <div class="col-md-7">
                <div class="row" style="padding: 5px;">
                    <div class="col-md-12 style_secao" style="display: inline; padding-top: 5px; padding-bottom: 5px;" id="id_area_secao">

                        <span style="position: relative; top: 10px;">{{$secao->nome}}</span>

                        <button id="btn_dropdown_opcoes_secao" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" style="float: right;" class="btn dropdown-toggle">
                            ⠇
                        </button>

                        <div class="dropdown-menu" aria-labelledby="btn_dropdown_opcoes_secao">
                            <button type="button" data-toggle="modal" data-target="#modal-criar-secao" onclick="add_id_na_subsecao({{$secao->id}})" class="dropdown-item">Adicionar Subseção</button>
                            <button type="button" class="dropdown-item" onclick="abrir_fechar_add_campo(true);">Adicionar Campo</button>
                            <hr style="width: 85%;">
                            <button type="button" data-toggle="modal" data-target="#modal-editar-secao" onclick="add_id_na_subsecao(null)" class="dropdown-item">Editar Seção</button>
                            <button type="button" class="dropdown-item btn btn-danger" style="color: red;" onclick="event.preventDefault(); document.getElementById('deletar_secao_form').submit();">Deletar Seção</button>

                            <form id="deletar_secao_form" action="{{ route('deletarSecao') }}" method="POST" class="d-none">
                                @csrf
                                <input type="hidden" name="secao_id" value="{{$secao->id}}" />
                            </form>

                        </div>


                        </span>



                    </div>


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
                                <textarea class="form-control" id="titulo" placeholder="Escreva o titulo do campo." name="titulo"></textarea>
                            </div>
                            <div style="float: right;">
                                <button type="button" class="btn btn-light" onclick="abrir_fechar_add_campo(false)">Cancelar</button>
                                <button id="btn_salvar_campo" type="submit" class="btn btn-success">Adicionar</button>
                            </div>
                        </form>
                    </div>




                    <!-- iterator de campo -->
                    <style>
                        .dropdown-toggle::after {
                            content: none;
                        }
                    </style>

                    @foreach($secao->campos as $campo)
                    <div class="col-md-12 style_card_secoes_atividade">
                        <div class="row">
                            <div id="div_titulo_campo_{{$campo->id}}" class="col" style=" width: 100%; text-align: center; cursor: pointer;">
                                {{$campo->titulo}}
                            </div>
                            <div class="col-1" style="text-align: right; right: 24px;">
                                <button id="btn_dropdown_opcoes_campo_{{$campo->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" class="btn btn-light dropdown-toggle" style="margin-top: -5px;margin-bottom: 7px;" onclick="abrir_fechar_add_campo(false)">
                                    <div width="4px">⠇</div>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btn_dropdown_opcoes_campo_{{$campo->id}}">
                                    <button type="button" class="dropdown-item" onclick="editar_campo('{{$campo->id}}', '{{$campo->titulo_escapado()}}')">Editar Titulo do Campo</button>
                                    <button type="button" class="dropdown-item btn btn-danger" onclick="document.getElementById('form_deletar_campo_{{$campo->id}}').submit();">Deletar Campo</button>
                                </div>

                                <form id="form_deletar_campo_{{$campo->id}}" method="POST" action="{{ route('deletarCampo') }}" class="d-none">
                                    @csrf
                                    <input type="hidden" name="campo_id" value="{{$campo->id}}">
                                </form>

                            </div>
                        </div>
                        <!-- TODO: conteudo do campo, que provavelmente vai ser um iframe com o editor, ou seja lá como é -->
                        <div id="conteudo_campo_{{$campo->id}}" class="collapse col-md-12">
                            <hr>

                            <form action="{{ route('salvarConteudo') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_campo" value="{{$campo->id}}" />
                                <textarea id="editor_campo_{{$campo->id}}" name="conteudo">
                                {{ $campo->conteudo }}
                                </textarea>
                                <button class="btn btn-success" style="margin-top: 10px; width: 100%;" type="submit">Salvar</button>
                            </form>
                            <hr>

                            <div id="anotacoes_campo_{{$campo->id}}"></div>

                            <script>
                                ClassicEditor
                                    .create(document.querySelector("#editor_campo_{{$campo->id}}"))
                                    .catch(error => {
                                        console.error(error);
                                    });

                                buscar_anotacoes_js("{{$campo->id}}", function(texto) {
                                    document.getElementById("anotacoes_campo_{{$campo->id}}").innerHTML = texto;
                                });
                            </script>


                            <form id="form_enviar_anotacao_{{$campo->id}}" method="POST" onsubmit="enviar_anotacao(this, anotacoes_campo_{{$campo->id}}, {{$campo->id}}); return false;" action="{{ route('anotacoes.salvar') }}">
                                @csrf
                                <input type="hidden" name="campo_id" value="{{$campo->id}}" />
                                <div class="form-group">
                                    <input class="form-control" style="display: inline-block; width: 85%;" type="text" placeholder="Comente algo sobre o campo" name="comentario" />
                                    <input name="btn_salvar_campo" class="btn btn-success comentario_campo" style="margin-top: -4px" type="submit" value="->" />
                                </div>
                            </form>
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



<script>
    Array.from(document.getElementById('container_secoes').querySelectorAll('.hr_div_secoes')).forEach((el) => {
        if (el.nextElementSibling) {
            if (el.nextElementSibling.classList.contains('hr_div_secoes')) {
                el.nextElementSibling.remove();
            }
        }
    });

    let irmao_ante = null;
    let irmao_post = null;

    Array.from(document.getElementById('container_secoes').querySelectorAll('.hr_div_secoes')).forEach((el) => {
        el.ondragover = function() {
            $(this).addClass("hr_div_secoes_ativo");
            irmao_ante = el.previousElementSibling;
            irmao_post = el.nextElementSibling;
        };

        el.ondragleave = function() {
            $(this).removeClass("hr_div_secoes_ativo");
        };

    });

    let secao_alvo = null;

    Array.from(document.getElementById('container_secoes').querySelectorAll('.link_secao_arrastavel')).forEach((el) => {


        el.ondragover = function() {
            $(this).addClass("link_secao_arrastado_sobre");
            secao_alvo = this;
        }

        el.ondragleave = function() {
            $(this).removeClass("link_secao_arrastado_sobre");
        }


        el.ondrag = function() {
            irmao_ante = null;
            irmao_post = null;
            secao_alvo = null;
        };

        el.ondragend = function() {
            let id_secao_arrastada = this.attributes["id_secao"].value;
            if (irmao_ante || irmao_post) {

                let id_irmao_ante = 0;
                let id_irmao_post = 0;

                if (irmao_ante) {
                    id_irmao_ante = irmao_ante.attributes["id_secao"].value;
                }

                if (irmao_post) {
                    id_irmao_post = irmao_post.attributes["id_secao"].value;
                }

                document.getElementById('id_irmao_ante').value = id_irmao_ante;
                document.getElementById('id_irmao_post').value = id_irmao_post;
                document.getElementById('id_secao_arrastada').value = id_secao_arrastada;
                document.getElementById('form_ordenar_secao').submit();
                mostrar_tela_carregamento();
                return;
            }

            if (secao_alvo) {
                let id_secao_alvo = secao_alvo.attributes["id_secao"].value;
                document.getElementById("id_secao_arrastada_que_vai_entrar").value = id_secao_arrastada;
                document.getElementById("id_secao_alvo").value = id_secao_alvo;
                document.getElementById("form_subsecionar_secao").submit();
                mostrar_tela_carregamento();
                return;
            }
        };
    });
</script>



@endsection
