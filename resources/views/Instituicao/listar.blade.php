@extends('layouts.app')
@section('content')
<div class="container-main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($instituicoes as $instituicao)
                <div class="row">
                    <div class="col">
                        <a href="{{route('instituicao.ver', $instituicao->id)}}"> {{$instituicao->nome}}</a>
                    </div>
                </div>
                @endforeach
                <a href="{{route('instituicao.nova')}}">Adicionar instituição</a>
            </div>
        </div>
    </div>
</div>
@endsection
