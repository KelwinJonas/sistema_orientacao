<nav class="navbar navbar navbar-expand-lg navbar-light bg-light">
    <div class="col-md-10">
        <div class="navbar-header">
            <a href="/login" class="navbar-brand" id="cor-texto-logo-navbar">
                <img id="logo-navbar" src="{{asset("images/logo_bussola_1.png")}}" alt="">
                Orientação
            </a>
        </div>
    </div>
    @auth
    <div class="col-md-2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Olá, <strong>{{Auth::user()->name}}</strong>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                    <a class="dropdown-item" href="{{route('templates.pessoais')}}">Meus modelos</a>

                    <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Sair') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
    @endauth
</nav>

<style>
    #navbarDropdown:after {
        display: inline-block;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        content: '';
    }
</style>
