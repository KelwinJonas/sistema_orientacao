{{-- Tela modal para criar uma atividade --}}
<div class="row">
    <div id="modal-criar-atividade" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="header-modal-criar-atividade">Criar atividade</h5>
                    <hr>
                    <form action="{{route('cadastrarAtividade.salvar')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tipo">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>

                            <select class="form-control" name="tipo" id="tipo_select">
                                <option disabled selected>-- Selecione um tipo --</option>
                                @foreach(\App\Models\AtividadeAcademica::TIPOS_SUGERIDOS as $tipo_sugerido)
                                <option value="{{$tipo_sugerido}}">{{$tipo_sugerido}}</option>
                                @endforeach
                                <option value="outros">Outro...</option>
                            </select>

                            <input type='text' class="d-none form-control campos-cadastro @error('tipo') is-invalid @enderror" placeholder="Digite o tipo" name='' id='tipo_txt' value="{{old('tipo')}}" style="margin-top: 15px;" />

                            <script>
                                document.getElementById('tipo_select').onchange = function() {
                                    if (this.value == "outros") {
                                        $('#tipo_txt').removeClass('d-none');
                                        document.getElementById('tipo_txt').name = "tipo";
                                        this.name = "";
                                    } else {
                                        $('#tipo_txt').addClass('d-none');
                                        document.getElementById('tipo_txt').name = "";
                                        this.name = "tipo";
                                    }
                                }
                            </script>

                            @error('tipo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="titulo">Título <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder="Digite o titulo" name='titulo' id='titulo' value="{{old('titulo')}}" />
                            @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <textarea name="descricao" id="descricao" class="form-control campos-cadastro @error('descricao') is-invalid @enderror" cols="30" rows="8"></textarea>
                            {{-- <input type='text' class="form-control campos-cadastro @error('titulo') is-invalid @enderror" placeholder = "Digite o titulo" name='titulo' id='titulo' value="{{old('titulo')}}"/> --}}
                            @error('descricao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="data_inicio">Data início <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='date' class="form-control campos-cadastro @error('data_inicio') is-invalid @enderror" name='data_inicio' id='data_inicio' value="{{old('data_inicio')}}" />
                            @error('data_inicio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="data_fim">Data fim <span class="cor-obrigatorio">(obrigatório)</span></label>
                            <input type='date' class="form-control campos-cadastro @error('data_fim') is-invalid @enderror" name='data_fim' id='data_fim' value="{{old('data_fim')}}" />
                            @error('data_fim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="cor_card">Cor do card <span class="cor-obrigatorio">(opcional)</span></label>
                            <div class="container custom-radios">
                                <div class="row justify-content-center">
                                    @for($i = 1; $i <= sizeof(\App\Models\AtividadeAcademica::CORES); $i++)
                                    <div>
                                        <input type="radio" class="radio-cor-{{$i}}" id="radio-cor-{{$i}}" name="cor_card" value="{{\App\Models\AtividadeAcademica::CORES[$i-1]}}" />
                                        <label class="label-radio" for="radio-cor-{{$i}}"><span class="span-radio" style="background-color: {{\App\Models\AtividadeAcademica::CORES[$i-1]}};"></span></label>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                <hr>
                <div class="float-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Criar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
