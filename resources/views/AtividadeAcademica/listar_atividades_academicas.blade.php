@extends('layouts.app')

@section('content')
    <br>
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
    </div>
@endsection