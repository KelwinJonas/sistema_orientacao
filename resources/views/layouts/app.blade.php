<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Orientação</title>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

    </head>
    <body>
        @include('layouts.navbar')

        @yield('content')
       
    </body>

    {{-- Footer --}}
    <footer id="rodape">
        <div class="row" id="conteudo-rodape">
            <hr class="col-md-12" size = 7 id="linha-rodape">
            <div class="col-md-4">
                <div class="row justify-content-center" id="div-logo-lmts">
                    <div class="col-12" id="div-label-lmts">Desenvolvido por:</div>
                    <a href="http://lmts.uag.ufrpe.br/">
                        <img src="{{asset("images/logo_lmts_p_branco.png")}}" alt="LMTS" width="200px"> 
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row justify-content-center" id="div-logo-ufape">
                    <div class="col-12" id="div-label-ufape">Apoio:</div>
                    <a href="http://ufape.edu.br/">
                        <img src="{{asset("images/logo_ufape_branco.png")}}" alt="UFAPE" width="240px"> 
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row justify-content-center" id="div-conteudo-redes-sociais">
                    <div class="col-12" id="div-label-redes-sociais">Redes sociais:</div>
                    <a href="https://www.facebook.com/LMTSUFAPE/">
                        <img src="{{asset("images/logo_facebook_branco.png")}}" class="imagens-redes-sociais">
                    </a>
                    <a href="https://www.instagram.com/lmts_ufape">
                        <img src="{{asset("images/logo_instagram_branco.png")}}" class="imagens-redes-sociais">
                    </a>
                    <a href="" target="_blank">
                        <img src="{{asset("images/logo_twitter_branco.png")}}" class="imagens-redes-sociais">
                    </a>
                </div>
            </div>
        </div>
    </footer>
</html>