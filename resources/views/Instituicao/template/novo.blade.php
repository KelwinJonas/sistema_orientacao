@extends('layouts.app')
@section('content')

    <div class="container-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <h3>Novo modelo</h3>
                        </div>
                    </div>

                    
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="row align-items-start">
                                <div class="col" style=" width: 100%;">
                                    <p class="style_pessoas_titulo">Tipo e titulo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="background-color: black; margin-top: -10px; height: 2px; margin-left: -15px; margin-right:-15px">
                        </div>
                    </div>

                    <form action="{{route('instituicao.template.salvar')}}" method="POST" id="form_template_editar">

                        @csrf
                        <input type="hidden" value="{{$instituicao->id}}" name="instituicao_id"/>
                        
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


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Adicionar</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

@endsection


