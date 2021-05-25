@extends('layouts.app')
@section('content')
    <script src="{{ asset('/js/funcoes_secoes_template.js') }}"></script>
    <script>
     document.onclick = function(evt) {
         esconder_contextos();
     }

     $(document).ready(function() {
         montar_arvores();
         carregar_arvore_secao_edits();
         carregar_scroll_menu_contexto();
     });
    </script>

    <div class="container-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <h3>{{$template->titulo}}</h3>
                        </div>
                    </div>

                    
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="row align-items-start">
                                <div class="col" style=" width: 100%;">
                                    <p class="style_pessoas_titulo">Seções e campos</p>
                                </div>
                                <div class="col" style="text-align: right;">
                                    <a href="#" class="btn btn-primary btn-sm" style="margin-top: 5px;" onclick="add_no_raiz(document.getElementById('form_template_editar'), 'secao')"  >Adicionar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="background-color: black; margin-top: -10px; height: 2px; margin-left: -15px; margin-right:-15px">
                        </div>
                    </div>



                    <form action="{{route('instituicao.template.editar.salvar')}}" method="POST" onsubmit="return preparar_template_form(event, this)" id="form_template_editar">

                        @csrf
                        <input type="hidden" name="template_id" value="{{$template->id}}">
                        <input type="hidden" value="" name="arr_template" id="arr_template" />
                        <input type="hidden" name="modal_ref" value="modal_edit_template_{{$template->id}}" />
                        <div class="form-group">
                            <label for="tipo">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='text' class="form-control campos-cadastro @error('tipo') is-invalid @enderror" placeholder="Digite o tipo" name='tipo' id='tipo' value="{{old('tipo', $template->tipo)}}" />
                            @error('tipo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="titulo">Titulo <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder="Digite o titulo" name='titulo' id='titulo' value="{{old('titulo', $template->titulo)}}" />
                            @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <hr>

                        <div id="arvore_secao_template_{{$template->id}}" class="no_raiz" dados_arvore="{{$template->arr_template}}">
                        </div>

                        <div id="titulo_campo_secao" style="display: none;">
                            <input id="texto_titulo" type="text" /><button type="button" style="margin-left: 1%;" class="btn btn-success" onclick="salvar_edit_secao_campo(this.parentNode)">Ok</button><br><br>
                        </div>

                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="confirm('Tem certeza que quer apagar esse modelo?') && document.getElementById('form_deletar_template_{{$template->id}}').submit()">Deletar</button>
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>

                    <form id="form_deletar_template_{{$template->id}}" class="d-none" method="POST" action="{{route('instituicao.template.deletar')}}">
                        @csrf
                        <input type="hidden" name="template_id" value="{{$template->id}}" />
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <div id="menu_contexto_edit_secao_campo">
        <ul id="menu_contexto_secao" style="display: none;">
            <li onclick="add_subsecao()"><a>Adicionar Subseção</a></li>
            <li onclick="add_campo()"><a>Adicionar Campo</a></li>
            <li onclick="preparar_editar_no_arvore()"><a>Renomear item</a></li>
            <li onclick="remover_no_arvore()"><a>Remover item</a></li>
        </ul>

        <ul id="menu_contexto_campo">
            <li onclick="preparar_editar_no_arvore()"><a>Renomear item</a></li>
            <li onclick="remover_no_arvore()"><a>Remover item</a></li>
        </ul>
    </div>

@endsection

