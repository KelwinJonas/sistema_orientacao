@extends('layouts.app')
@section('content')

    <div class="container-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <h3>{{$instituicao->nome}}</h3>
                        </div>
                    </div>
                    
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="row align-items-start">
                                <div class="col" style=" width: 100%;">
                                    <p class="style_pessoas_titulo">Modelos</p>
                                </div>
                                <div class="col" style="text-align: right;">
                                    <a href="{{route('instituicao.template.novo', $instituicao->id)}}" class="btn btn-primary btn-sm" style="margin-top: 5px;">Adicionar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="background-color: black; margin-top: -10px; height: 2px; margin-left: -15px; margin-right:-15px">
                        </div>
                    </div>
                    @foreach($instituicao->templatesAtividade as $template)
                        <div class="col-md-12 style_card_pessoas_atividade" onclick="document.location='{{route('instituicao.template.ver', $template->id)}}'">
                            <div class="row align-items-start">
                                <div style="width: 40px;margin-left:15px; margin-bottom:15px;">
                                    <img src="{{asset('images/logo_novo_user.png')}}" alt="Orientação" width="40px">
                                </div>
                                <div class="col link_instituicao" style="width: 100%; margin-top: 10px;">
                                    <div>{{$template->titulo}} <span style="color: #909090; font-size: 13px;"></span></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
