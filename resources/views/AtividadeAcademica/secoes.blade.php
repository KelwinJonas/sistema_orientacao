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
                                        <a class="col"  id="botao-criar-secao" data-toggle="modal" data-target="#modal-criar-secao" style="text-align:right; font-size: 15px;" onclick="add_id_na_subsecao(null)">Criar</a>
                                    </div>
                                </div>
                                <div class="col-md-12" style="color: #909090;">
                                    <div class="row">
                                        <script>
                                         function add_id_na_subsecao(id) {
                                             document.getElementById("secao_id").value = id;
                                         }

                                        </script>
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
                    @include('AtividadeAcademica.modal_editar_secao')
                    <script>document.getElementById("botao-editar-secao").click();</script>
                    @php session()->put('_old_input', []); @endphp
                @endif

                @include('AtividadeAcademica.modal_criar_secao')

                @if(session("localizacao_erro") == "criar")
                    <script>document.getElementById("botao-criar-secao").click();</script>
                    @php session()->put('_old_input', []); @endphp
                @endif


                @if(isset($secao))
                    @if(session("localizacao_erro") != "editar")
                        @include('AtividadeAcademica.modal_editar_secao')
                    @endif
                    <div class="col-md-7">


                        <!-- Aqui deve ser adicionar o campo a esta  seção -->
                        <script>
                         function abrir_fechar_add_campo(abrir) { // se abrir for true, abre, se não, fecha
                             document.getElementById("id_area_secao").style.display = (abrir ? "none" : "block");
                             document.getElementById("id_area_secao_texto").style.display = (abrir ? "block" : "none");
                             document.getElementById("campo_id").value = null;
                             document.getElementById("titulo").value = "";
                             document.getElementById("btn_salvar_campo").innerHTML= "Adicionar";
                         }

                         function editar_campo(id_campo, titulo_campo) {
                             abrir_fechar_add_campo(true);
                             document.getElementById("campo_id").value = id_campo;
                             document.getElementById("titulo").value = String(titulo_campo).replace("\"", "").split("").reverse().join("").replace("\"", "").split("").reverse().join("");
                             document.getElementById("btn_salvar_campo").innerHTML= "Salvar";
                         }


                         function buscar_anotacoes_js(id_campo, callback_uso) {
                             let url = "http://127.0.0.1:8000/anotacoes/" + id_campo;
                             fetch(url)
                                 .then(function (response) {
                                     return response.text();
                                 })
                                 .then(function (texto) {
                                     callback_uso(texto);
                                 })
                                 .catch(function (error) {
                                     console.log("Campo " + id_campo + ", Erro para conseguir as anotações: " + error);
                                     callback_uso("");
                                 });

                         }

                         function enviar_anotacao(form, anotacoes, id_campo) {
                             //submit
                             const XHR = new XMLHttpRequest();
                             const FD  = new FormData();
                             let input_comentario;
                             let btn_comentario;

                             let urlEncodedDataPairs = [];
                             for(let input of form.querySelectorAll("input")) {
                                 if(input.name === "comentario" && input.value.length < 2) {return;}
                                 FD.append(input.name, input.value);
                                 if(input.name === "comentario") {input_comentario = input;}
                                 if(input.name === "btn_salvar_campo") {btn_comentario = input;}
                             }
                             btn_comentario.style.display = "none";

                             XHR.addEventListener( 'load', function(event) {
                                 console.log(event);
                                 input_comentario.value = "";
                                 btn_comentario.style.display = "inline-block";
                             } );

                             XHR.addEventListener( 'error', function(event) {
                                 alert('Não foi possivel enviar a anotação');
                                 btn_comentario.style.display = "inline-block";
                             } );

                             XHR.open('POST', form.action);
                             XHR.send(FD);

                             //baixar anotacoes dnv
                             buscar_anotacoes_js(id_campo, function(texto) { anotacoes.innerHTML = texto; });
                         }

                         function deletar_anotacao(id) {
                             document.getElementById("anotacao_" + id).style.display = "none";
                             let form = document.getElementById("form_deletar_anotacao_" + id);

                             //submit
                             const XHR = new XMLHttpRequest();
                             const FD  = new FormData();

                             let urlEncodedDataPairs = [];
                             for(let input of form.querySelectorAll("input")) {
                                 FD.append(input.name, input.value);
                             }

                             XHR.open('POST', form.action);
                             XHR.send(FD);
                         }
                         
                        </script>

                        <div class="row" style="padding: 5px;">
                            <!-- area de criação de mensagens -->
                            <div class="col-md-12 style_secao" onclick="abrir_fechar_add_campo(true)" style="display: block;" id="id_area_secao">Clique aqui para adicionar um campo na seção {{$secao->nome}}</div>
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
                                            <button type="button" class="btn btn-light" style="margin-top: -5px;margin-bottom: 7px;" onclick="abrir_fechar_add_campo(false)"><div width="16px" style="margin-top: -4px;">✖</div></button>
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
                                        conteudos nice dimai
                                        <hr>

                                        <div id="anotacoes_campo_{{$campo->id}}"></div>
                                        <script>
                                         buscar_anotacoes_js("{{$campo->id}}", function(texto) {
                                             document.getElementById("anotacoes_campo_{{$campo->id}}").innerHTML = texto;
                                         });
                                        </script>


                                        <form id="form_enviar_anotacao_{{$campo->id}}"
                                              method="POST"
                                              onsubmit="enviar_anotacao(this, anotacoes_campo_{{$campo->id}}, {{$campo->id}}); return false;"
                                              action="{{ route('anotacoes.salvar') }}">
                                            @csrf
                                            <input type="hidden" name="campo_id" value="{{$campo->id}}" />
                                            <div class="form-group">
                                                <input class="form-control" style="display: inline-block; width: 85%;" type="text" name="comentario" />
                                                <input name ="btn_salvar_campo" class="btn btn-success comentario_campo" style="margin-top: -4px" type="submit" value="->" />
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
                @endif
            </div>
        </div>
    </div>
@endsection
