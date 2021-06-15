@extends('layouts.app')
@section('content')
    <div class="container-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row" style="padding: 5px;">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="row align-items-start">
                                <div class="col" style=" width: 100%;">
                                    <p class="style_pessoas_titulo">Gerentes de instituições</p>
                                </div>
                                @include('Instituicao.modal_novo_gerente') 
                                <div class="col" style="text-align: right;">
                                    <a href="#" data-toggle="modal" data-target="#modal-adicionar-gerente" class="btn btn-primary btn-sm" style="margin-top: 5px;">Adicionar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="background-color: black; margin-top: -10px; height: 2px; margin-left: -15px; margin-right:-15px">
                        </div>
                        @foreach ($users as $user)
                            @if($user->id != Auth::id())
                                <div class="col-md-12 style_card_pessoas_atividade" style="cursor: auto;">
                                    <div class="row align-items-start">
                                        <div style="width: 40px;margin-left:15px; margin-bottom:15px;">
                                            <img src="{{asset('images/logo_novo_user.png')}}" alt="Orientação" width="40px">
                                        </div>
                                        <div class="col" style="width: 100%; margin-top: 10px;">
                                            <div>{{$user->name}} <span style="color: #909090; font-size: 13px;"></span></div>
                                        </div>
                                        <div id="btn_opcoes_users_{{$user->id}}" class="col-1" style="text-align: right; margin-top: 10px; cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="{{asset('images/logo_more.png')}}" alt="Opções" width="4px">
                                        </div>
                                        <div class="dropdown-menu" aria-labelledby="btn_opcoes_users_{{$user->id}}">
                                            <button type="button" class="dropdown-item btn btn-danger" style="color: red;" onclick="confirm('Tem certeza que quer remover as permissões?') && document.getElementById('form_deletar_user_{{$user->id}}').submit();"  >Remover</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <form method="POST" action="{{route('instituicao.gerente.remover')}}" id="form_deletar_user_{{$user->id}}" class="d-none">
                                    @csrf
                                    <input type="hidden" name="email" value="{{$user->email}}" />
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

