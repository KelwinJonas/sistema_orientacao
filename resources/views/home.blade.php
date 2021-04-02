@extends('layouts.app')

@section('content')
    <div class="container-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" id="div-conteudo">
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
                                <div class="col-md-12" id="div-cabecalho-login">Olá, seja bem vindo(a)!</div>
                                <form>
                                    <div class="form-group" id="div-campo-email">
                                      <label for="email">E-mail</label>
                                      <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Digite seu e-mail">
                                    </div>
                                    <div class="form-group">
                                      <label for="password">Senha</label>
                                      <input type="password" class="form-control" id="password" placeholder="Digite sua senha">
                                    </div>
                                    <div class="form-check" id="div-lembrar-senha">
                                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                      <label class="form-check-label" for="exampleCheck1">Lembrar Senha </label>
                                    </div>
                                    <a href="./pagina_inicial.html" class="btn btn-success" id="botao-entrar">Entrar</a>
                                </form>
                                    <div id="div-esqueceu-senha">
                                        <a href="#" >Esqueceu sua senha?</a>
                                    </div>
                                    <div id="div-ou">
                                        <h6>OU</h4>
                                    </div>
                                    <div class="google-btn" style="width: 100%;">
                                        <a href="{{route("loginGoogle")}}" id="link-botao-google">
                                            <div class="google-icon-wrapper">
                                                <img class="google-icon" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg"/>
                                              </div>
                                              <p class="btn-text"><b>Continue with Google</b></p>
                                        </a>
                                    </div>
                                    <hr>
                                    <label for="cadastrese" id="label-cadastrese">Ainda não está cadastrado(a)? </label>
                                    <a href="{{route("cadastrarUsuario")}}" class="btn btn-primary" id="botao-cadastrese">Cadastre-se</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
