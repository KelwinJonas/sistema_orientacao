<div id="modal-adicionar-gerente" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="header-modal-criar-atividade">Adicionar gerente de instituição</h5>
                <hr>
                
                <form action="{{route('instituicao.gerentes.adicionar.salvar')}}" method="POST">
                    @csrf
                    <div class="form-group" id="div-email-esqueceu-senha">
                        <label for="nome">E-mail <span class="cor-obrigatorio"></span></label>
                        <input type='text' class="form-control  campos-cadastro @error('email') is-invalid @enderror" placeholder = "Digite o e-mail de quem vai ser o gerente" name='email' id='email' value="{{old('email')}}"/>    
                        @error('email')
                        <script>
                         $("#modal-adicionar-gerente").modal("show");
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

