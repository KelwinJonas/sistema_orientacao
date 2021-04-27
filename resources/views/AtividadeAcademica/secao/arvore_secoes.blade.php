@if($atividade->secoes->count() == 0)
<p class="col">
    Nenhuma seção criada.
    <br>
    <a id="botao-criar-secao" data-toggle="modal" data-target="#modal-criar-secao" style="text-align:right; font-size: 15px; color: blue;" onclick="add_id_na_subsecao(null)">
        Clique aqui
    </a>
    para criar uma seção.
</p>
@endif
<!-- TODO: se o nome tiver html, ele pode ser injetado... -->
@foreach($atividade->secoes as $secao_loop)
    @php echo $secao_loop->arvore_secoes($secao); @endphp
@endforeach
