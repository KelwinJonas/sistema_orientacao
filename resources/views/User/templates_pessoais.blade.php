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

<div class="modal fade" id="modal_add_template" tabindex="-1" role="dialog" aria-labelledby="add_template_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_template_label">Adicionar modelo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.template.salvar')}}" method="POST">

                    @if(old('modal_ref') != "modal_add_template")
                    <?php
                    $old_input_salva = session('_old_input');
                    session()->put('_old_input', []);
                    $erros_salvos = $errors;
                    $errors = new Illuminate\Support\ViewErrorBag;
                    ?>
                    @endif

                    @csrf
                    <input type="hidden" name="modal_ref" value="modal_add_template" />
                    <div class="form-group">
                        <label for="tipo">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('tipo') is-invalid @enderror" placeholder="Digite o tipo" name='tipo' id='tipo' value="{{old('tipo')}}" />
                        @error('tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="titulo">Titulo <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder="Digite o titulo" name='titulo' id='titulo' value="{{old('titulo')}}" />
                        @error('titulo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>

                    @if(empty(session('_old_input')))
                    <?php
                    session()->put('_old_input', $old_input_salva);
                    $errors = $erros_salvos;
                    ?>
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="container-main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <br>
                <div class="card">
                    <h5 class="card-header">Templates pessoais</h5>
                    <div class="card-body">
                        <a id="btn_abrir_modal_add_template" href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_template">Adicionar modelo</a>
                        @foreach(Auth::user()->templates_pessoais as $template)
                        <div class="modal fade modal_edit_template_c" id="modal_edit_template_{{$template->id}}" tabindex="-1" role="dialog" aria-labelledby="edit_template_label" aria-hidden="true">
                            <div class="modal-dialog" role="document" style="max-width: 70%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="edit_template_label">Editar modelo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('user.template.editar.salvar')}}" method="POST" onsubmit="return preparar_template_form(event, this)">

                                            @if(old('modal_ref') != "modal_edit_template_$template->id")
                                            <?php
                                            $old_input_salva = session('_old_input');
                                            session()->put('_old_input', []);
                                            $erros_salvos = $errors;
                                            $errors = new Illuminate\Support\ViewErrorBag;
                                            ?>
                                            @endif

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

                                            <hr>

                                            <div id="titulo_campo_secao" style="display: none;">
                                                <input id="texto_titulo" type="text" /><button type="button" style="margin-left: 1%;" class="btn btn-success" onclick="salvar_edit_secao_campo(this.parentNode)">Ok</button><br><br>
                                            </div>
                                            <button type="button" class="btn btn-primary" onclick="add_no_raiz(this.parentNode, 'secao')">Adicionar Seção</button>
                                            <br><br>

                                            @if(empty(session('_old_input')))
                                            <?php
                                            session()->put('_old_input', $old_input_salva);
                                            $errors = $erros_salvos;
                                            ?>
                                            @endif

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" onclick="confirm('Tem certeza que quer apagar esse modelo?') && document.getElementById('form_deletar_template_{{$template->id}}').submit()">Deletar</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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

                        <div>
                            <a href="#" data-toggle="modal" data-target="#modal_edit_template_{{$template->id}}">
                                {{$template->titulo}}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
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

@if ($errors->any())
    <script>
     $("#{{old('modal_ref')}}").modal("show");
    </script>
@endif

@endsection

