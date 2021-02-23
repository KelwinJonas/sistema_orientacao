@extends('layouts.app')

@section('content')
    <div class="container-main">
        <form action="" method="POST"> 
            {{-- {{route('')}} --}}
            @csrf
            <br>
            <h1 class="col-md-1">Cadastro</h1>
            <h2 class="col-md-6">Informações da Instituição</h2>

            <div class="form-group">
                <label for='nome' class="col-md-1 col-form-label">Nome</label>
                <div class="col-md-6">
                    <input type='text' class="form-control @error('nome') is-invalid @enderror" placeholder = "Digite o nome da instituição" name='nome' id='nome' value="{{old('nome')}}"/>    
                    @error('nome')
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