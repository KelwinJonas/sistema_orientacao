<div id="modal-criar-instituicao" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="header-modal-criar-atividade">Adicionar Instituição</h5>
                <hr>
                
                <form action="{{route('instituicao.salvar')}}" method="POST">
                    @csrf
                    <div class="form-group" id="div-email-esqueceu-senha">
                        <label for="nome">Nome <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input type='text' class="form-control  campos-cadastro @error('nome') is-invalid @enderror" placeholder = "Digite o nome da instituição" name='nome' id='nome' value="{{old('nome')}}"/>    
                        @error('nome')
                        <script>
                         $("#modal-criar-instituicao").modal("show");
                        </script>
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <hr>
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

