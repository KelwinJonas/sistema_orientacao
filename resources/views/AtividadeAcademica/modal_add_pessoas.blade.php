{{-- Modal adicionar pessoas --}}
<script>
    function fuzzy_search(orig, escrito) {
        orig = orig.toLowerCase();
        let i = 0;
        let n = -1
        let l;
        escrito = escrito.toLowerCase();
        for (; l = escrito[i++];)
            if (!~(n = orig.indexOf(l, n + 1))) return false;
        return true;
    }


    let lista_users_orig = <?php echo \App\Models\User::lista_busca(); ?>;
    var lista_users_exibida = <?php echo \App\Models\User::lista_busca(); ?>;

    function preencher_nome_email_automatico(obj) {
        let dados = obj.innerHTML.split(' - ');
        document.getElementById('email').value = dados[1];
    }

    function mostrar_lista_sugestoes() {
        let div_lista = document.getElementById('container_lista_sugestoes');
        div_lista.innerHTML = "";
        for (let sugestao of lista_users_exibida) {
            div_lista.innerHTML += "<div onmousedown='preencher_nome_email_automatico(this)' onmouseover='preencher_nome_email_automatico(this)' class='sugestao_div'>" + sugestao.name + ' - ' + sugestao.email + "</div>";
        }
    }

    function atualizar_lista_sugestoes(input) {
        lista_users_exibida = lista_users_orig.filter((el) => {
            return (fuzzy_search(el.name, input.value) || fuzzy_search(el.email, input.value));
        });
        mostrar_lista_sugestoes();
    }

    $(document).ready(function() {
        document.getElementById('email').onfocusout = function() {
            /* document.getElementById('container_lista_sugestoes').innerHTML = ""; */
            $('#container_lista_sugestoes').addClass('d-none');
        }

        document.getElementById('email').onfocus = function() {
            atualizar_lista_sugestoes(document.getElementById('email'));
            mostrar_lista_sugestoes();
            $('#container_lista_sugestoes').removeClass('d-none');
        }


    });
</script>


<div id="modal-adicionar-pessoa" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="header-modal-criar-atividade">Adicionar pessoa</h5>
                <hr>
                <form action="{{route('verAtividade.salvarAdicionarPessoa', ['atividade_id' => $atividade->id])}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <input onkeyup="atualizar_lista_sugestoes(this)" autocomplete="off" type='text' class="form-control campos-cadastro @error('email') is-invalid @enderror" placeholder="Digite o email" name='email' id='email' value="{{old('email')}}" />
                        <div id="container_lista_sugestoes" class="d-none"></div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="papel">Papel <span class="cor-obrigatorio">(obrigatório)</span></label>
                        <select class="form-control campos-cadastro @error('papel') is-invalid @enderror" name='papel' id='papel' value="{{old('papel')}}">
                            <option disabled selected>Selecione o papel</option>
                            @foreach(App\Models\Papel::PAPEIS as $nome_bonito => $papel)
                            <option value="{{$papel}}">{{$nome_bonito}}</option>
                            @endforeach
                        </select>
                        @error('papel')
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
