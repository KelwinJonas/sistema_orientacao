@extends('layouts.app')

@section('content')
    <div class="container-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" id="div-conteudo-esqueceu-senha">
                    <div class="container" id="div-conteudo-container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row" id="div-coluna1-logo">
                                    <div class="col-md-12" id="div-logo">
                                        <img src="{{asset("images/logo_bussola_2.png")}}" alt="Orientação" width="100%"> 
                                    </div>
                                    <div class="col-md-12" id="div-texto">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                                </div>
                            </div>
                            <div class="col-md-6" id="div-coluna2">
                                <div class="col-md-12" id="cabecalho-cadastro-usuario">Esqueceu a senha?</div>
                                <label id="legenda-redefinicao-senha">Digite seu email abaixo para receber um link para redefinição de senha</label>

                                <form action="" method="POST">
                                    @csrf

                                    <div class="form-group" id="div-email-esqueceu-senha">
                                        <label for="email">E-mail <span class="cor-obrigatorio">(obrigatório)</span></label>
                                        <input type='text' class="form-control  campos-cadastro @error('email') is-invalid @enderror" placeholder = "Digite seu email" name='email' id='email' value="{{old('email')}}"/>    
                                          @error('email')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{$message}}</strong>
                                              </span>
                                          @enderror
                                    </div>
                                        <button type="submit" class="btn btn-success botoes-cadastro">Enviar link para redefinição de senha</button>
                                        <hr>
                                        <a href="{{route('home')}}" class="btn btn-primary botoes-cadastro" >Voltar para a tela de login</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection