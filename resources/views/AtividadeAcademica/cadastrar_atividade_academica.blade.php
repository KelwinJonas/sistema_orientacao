@extends('layouts.app')

@section('content')
    <div class="container-main">
        <form action="{{route('cadastrarAtividade.salvar')}}" method="POST"> 
            @csrf
            <br>
            <h1 class="col-md-1">Cadastro</h1>
            <h2 class="col-md-6">Informações da Atividade</h2>

            <div class="form-group">
                <label for='tipo' class="col-md-1 col-form-label">Tipo</label>
                <div class="col-md-6">
                    <input type='text' class="form-control @error('tipo') is-invalid @enderror" placeholder = "Digite o tipo da atividade" name='tipo' id='tipo' value="{{old('tipo')}}"/>    
                    @error('tipo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
                <label for='titulo' class="col-md-1 col-form-label">Título</label>
                <div class="col-md-6">
                    <input type='text' class="form-control @error('titulo') is-invalid @enderror" placeholder = "Digite o título da atividade" name='titulo' id='titulo' value="{{old('titulo')}}"/>    
                    @error('titulo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
                <label for='data_inicio' class="col-md-2 col-form-label">Data início</label>
                <div class="col-md-6">
                    <input type='date' class="form-control @error('data_inicio') is-invalid @enderror" placeholder = "" name='data_inicio' id='data_inicio' value="{{old('data_inicio')}}"/>    
                    @error('data_inicio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
                <label for='data_fim' class="col-md-2 col-form-label">Data fim</label>
                <div class="col-md-6">
                    <input type='date' class="form-control @error('data_fim') is-invalid @enderror" placeholder = "" name='data_fim' id='data_fim' value="{{old('data_fim')}}"/>    
                    @error('data_fim')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-1">
                <button id="botao-cadastrar" type='submit' class="btn btn-primary cor-botao" >Cadastrar</button>
            </div>

        </form>
    </div>
@endsection