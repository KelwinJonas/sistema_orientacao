@extends('layouts.app')

@section('content')
    <div class="container-main">
        <br>
        <div>
            <h2>Título do projeto: {{$atividade->titulo}}</h2>
        </div>
        <br>
        <div class="form-row">
            <div class="col">
                <a type="button" class="btn btn-success" data-toggle = "modal" data-target="#adicionarSecao" href="" >Adicionar seção +</a>
            </div>
        </div>
        <div>
            <br>
        </div>
        <div id="secoes" class="form-row">
             
        </div>
        <br>
        <div id="conteudo-secoes" style="display:none" class="jumbotron">
            <div id="legenda_secao">

            </div>
            <div>
                <a type="button" class="btn btn-success" data-toggle = "modal" data-target="#adicionarCampo" href="" >Adicionar campo +</a>
            </div>
            <br>
            <div id="adicionarCampo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div id="contentModal" class="modal-content">
                        <div class="col-md-12">
                            <br>
                            <h5 class="modal-title" id="titulo">Adicionar campo</h5>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <label for="">Informações</label>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-4">
                                    <label>Nome do campo</label>
                                    <input type="text" class="form-control" name='nomeCampo' id='nomeCampo' placeholder="Digite o nome do campo" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="botaoAdicionarCampo" type="submit" data-dismiss="modal" class="btn btn-success" onclick="adicionarCampo(event)">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="botoes-campos" class="form-row">
                
            </div>
            <br>
            <div id="texto-campos">

            </div>
        </div>  
        <div id="adicionarSecao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div id="contentModal" class="modal-content">
                    <div class="col-md-12">
                        <br>
                        <h5 class="modal-title" id="titulo">Adicionar seção</h5>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <label for="">Informações</label>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-4">
                                <label>Nome da seção</label>
                                <input type="text" class="form-control" name='nomeSecao' id='nomeSecao' placeholder="Digite o nome da seção" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-4">
                                <label>Legenda</label>
                                <input type="text" class="form-control" name='legendaSecao' id='legendaSecao' placeholder="Digite a legenda da seção" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="botaoAdicionarSecao" type="submit" data-dismiss="modal" class="btn btn-success" onclick="adicionarSecao(event)">Adicionar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let ordem = 0;
        let ordemCampo = 0;

        function adicionarSecao(event){
            event.preventDefault();
            ordem += 1;
            nomeSecao = document.getElementById('nomeSecao');
            legendaSecao = document.getElementById('legendaSecao');
            botaoNovo = montarBotaoNovoSecao(ordem, nomeSecao.value, legendaSecao.value);
            $('#secoes').append(botaoNovo);
        }

        function montarBotaoNovoSecao(ordem, valorNomeSecao, legendaSecao){
            return `<div id="${ordem}" class="row-md-5">
                        <button id="${ordem}"type="button" class="btn btn-primary mx-2" onclick="mostrarConteudo()">${valorNomeSecao}</button>
                    </div>
                    `;
        }

        function mostrarConteudo(){
            var display = document.getElementById('conteudo-secoes').style.display;
            if(display == "none")
                document.getElementById('conteudo-secoes').style.display = 'block';
            else
                document.getElementById('conteudo-secoes').style.display = 'none';

        }
        //<button type="button" class="btn btn-primary mx-2" onclick="adicionarConteudoSecao(${ordem})">${valorNomeSecao}</button>


        //Colocar para exibir conteúdo apenas quando houver o click do botão da seção
        // function adicionarConteudoSecao(ordemSecao){
        //     conteudoSecao = montarConteudoSecao(ordemSecao);
        //     $('#conteudo-secoes').append(conteudoSecao);
        // }

        // function montarConteudoSecao(ordemSecao){
        //     return `
        //             `;
        // }

        function adicionarCampo(event){
            event.preventDefault();
            ordemCampo += 1;
            nomeCampo = document.getElementById('nomeCampo');
            botaoNovo = montarBotaoNovoCampo(ordemCampo, nomeCampo.value);
            $('#botoes-campos').append(botaoNovo);
        }

        function montarBotaoNovoCampo(ordemCampo, valorNomeCampo){
            return `
                    <div id="${ordemCampo}" class="row-md-5">
                        <button type="button" class="btn btn-primary mx-2" onclick="adicionarConteudoCampo(${ordemCampo})">${valorNomeCampo}</button>
                    </div>
                    `;
        }

        function adicionarConteudoCampo(ordemCampo){
            conteudoCampo = montarConteudoCampo(ordemCampo);
            $('#texto-campos').append(conteudoCampo);
        }

        function montarConteudoCampo(ordemCampo){
            return `
                    <div>
                        <textarea name="textoCampo" id="textoCampo${ordemCampo}" cols="114" rows="10"></textarea>
                    </div>
            `;
        }
    </script>
@endsection