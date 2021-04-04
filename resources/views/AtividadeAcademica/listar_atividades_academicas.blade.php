@extends('layouts.app')

@section('content')
    <div class="container-main">
        <div class="container">
            <div class="col-md-12" id="cabecalho-listar-atividades">Minhas atividades</div>
            <div id="div-lista-de-atividades">
                <div class="row">
                    @foreach ($atividades as $atividade)
                        <div class="style_card_tema">
                            <div class="container div-conteudo-card">
                                <div class="row">
                                    <div class="col-md-12 div-titulo-card">
                                        <a class="link-titulo-atividade" href="#">{{$atividade->titulo}}</a>
                                    </div>
                                    <div class="col-md-12">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a...
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 div-usuario">
                                    <img src="{{asset('images/logo_user_default.png')}}" alt="Orientação" width="35px"> 
                                    <span style="font-size: 15px;">Fulano</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- <br>
    <h2>Minhas atividades</h2>

    <div style="overflow: auto; height: 450px">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="">Título</th>
                    <th scope="col" class="">Tipo da atividade</th>
                    <th scope="col" class="">Data início</th>
                    <th scope="col" class="">Data fim</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atividades as $atividade)
                    <tr class='atividade'>
                        <td class='titulo'><a href="{{route('verAtividade', ['atividade_id' => $atividade->id])}}">{{$atividade->titulo}}</a></td>
                        <td class='tipo'>{{$atividade->tipo}}</td>
                        <td class='data_inicio'>{{$atividade->data_inicio}}</td>
                        <td class='data_fim'>{{$atividade->data_fim}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
@endsection