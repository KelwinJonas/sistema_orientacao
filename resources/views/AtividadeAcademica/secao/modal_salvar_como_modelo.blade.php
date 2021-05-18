<div id="modal-salvar-template-pessoal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="header-modal-salvar">Salvar modelo</h5>
                <hr>
                <form action="{{route('templates.pessoais.salvar')}}" method="POST">
                    @csrf
                    <input type="hidden" name="atividade_id" value="{{$atividade->id}}" />
                    <div class="form-group">
                        <label for="tipo_template">Tipo <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro" placeholder="Digite o tipo" name='tipo_template' id='tipo_template' value="{{old('tipo_template')}}" />
                        @error('tipo_template')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="titulo_template">Titulo <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control campos-cadastro" placeholder="Digite o titulo" name='titulo_template' id='titulo_template' value="{{old('titulo_template')}}" />
                        @error('titulo_template')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <hr>
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<br>
<a   data-toggle="modal" data-target="#modal-salvar-template-pessoal" style="color: black;" href="#">Salvar como modelo pessoal</a>
