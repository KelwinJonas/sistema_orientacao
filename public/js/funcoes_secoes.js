function enviar_form(form, callback) {
    var url = $(form).attr("action");
    var dados = {};
    $(form).find("input[name]").each(function(index, no) {
        dados[no.name] = no.value;
    });
    $.post(url, dados).done(function(resposta) {
        callback(resposta);
    });
}

function mostrar_tela_carregamento_arvore_secoes() {
    document.getElementById('container_secoes').innerHTML = "<div style='margin-left:42%;' class='spinner-border' role='status'><span class='sr-only'>Carregando...</span></div>";
}

function fazer_arvore_arrastavel() {

    Array.from(document.getElementById('container_secoes').querySelectorAll('.hr_div_secoes')).forEach((el) => {
        if (el.nextElementSibling) {
            if (el.nextElementSibling.classList.contains('hr_div_secoes')) {
                el.nextElementSibling.remove();
            }
        }
    });

    let irmao_ante = null;
    let irmao_post = null;

    Array.from(document.getElementById('container_secoes').querySelectorAll('.hr_div_secoes')).forEach((el) => {
        el.ondragover = function() {
            $(this).addClass("hr_div_secoes_ativo");
            irmao_ante = el.previousElementSibling;
            irmao_post = el.nextElementSibling;
        };

        el.ondragleave = function() {
            $(this).removeClass("hr_div_secoes_ativo");
        };

    });

    let secao_alvo = null;
    let is_chrome = ((navigator.userAgent.toLowerCase().indexOf('chrome') > -1) && (navigator.vendor.toLowerCase().indexOf("google") > -1));

    Array.from(document.getElementById('container_secoes').querySelectorAll('.link_secao_arrastavel')).forEach((el) => {


        el.ondragover = function() {
            $(this).addClass("link_secao_arrastado_sobre");
            secao_alvo = this;
        }

        el.ondragleave = function() {
            $(this).removeClass("link_secao_arrastado_sobre");
        }


        el.ondrag = function(evt) {
            if (is_chrome) {
                if (evt.screenX == 0 && evt.screenY == 0) {
                    return;
                }
            }

            irmao_ante = null;
            irmao_post = null;
            secao_alvo = null;
        };

        el.ondragend = function() {
            let id_secao_arrastada = this.attributes["id_secao"].value;
            if (irmao_ante || irmao_post) {

                let id_irmao_ante = 0;
                let id_irmao_post = 0;

                if (irmao_ante) {
                    id_irmao_ante = irmao_ante.attributes["id_secao"].value;
                }

                if (irmao_post) {
                    id_irmao_post = irmao_post.attributes["id_secao"].value;
                }

                document.getElementById('id_irmao_ante').value = id_irmao_ante;
                document.getElementById('id_irmao_post').value = id_irmao_post;
                document.getElementById('id_secao_arrastada').value = id_secao_arrastada;
                mostrar_tela_carregamento_arvore_secoes();
                enviar_form(document.getElementById('form_ordenar_secao'), function(_resp) {
                    recarregar_arvore_secoes(fazer_arvore_arrastavel);
                });
                return;
            }

            if (secao_alvo) {
                let id_secao_alvo = secao_alvo.attributes["id_secao"].value;
                document.getElementById("id_secao_arrastada_que_vai_entrar").value = id_secao_arrastada;
                document.getElementById("id_secao_alvo").value = id_secao_alvo;
                mostrar_tela_carregamento_arvore_secoes();
                enviar_form(document.getElementById("form_subsecionar_secao"), function(_resp) {
                    recarregar_arvore_secoes(fazer_arvore_arrastavel);
                });
                return;
            }
        };
    });
}

$(document).ready(() => {
    fazer_arvore_arrastavel();
});


function abrir_fechar_add_campo(abrir) { // se abrir for true, abre, se não, fecha
    document.getElementById("id_area_secao").style.display = (abrir ? "none" : "block");
    document.getElementById("id_area_secao_texto").style.display = (abrir ? "block" : "none");
    document.getElementById("campo_id").value = null;
    document.getElementById("titulo").value = "";
    document.getElementById("btn_salvar_campo").innerHTML = "Adicionar";
}

function editar_campo(id_campo, titulo_campo, legenda_campo) {
    abrir_fechar_add_campo(true);
    document.getElementById("campo_id").value = id_campo;
    document.getElementById("titulo").value = String(titulo_campo).replace("\"", "").split("").reverse().join("").replace("\"", "").split("").reverse().join("");
    document.getElementById("legenda_campo").value = String(legenda_campo).replace("\"", "").split("").reverse().join("").replace("\"", "").split("").reverse().join("");
    document.getElementById("btn_salvar_campo").innerHTML = "Salvar";
}

function enviar_anotacao(form, anotacoes, id_campo) {
    //submit
    const XHR = new XMLHttpRequest();
    const FD = new FormData();
    let input_comentario;
    let btn_comentario;

    let urlEncodedDataPairs = [];
    for (let input of form.querySelectorAll("input")) {
        if (input.name === "comentario" && input.value.length < 2) {
            return;
        }
        FD.append(input.name, input.value);
        if (input.name === "comentario") {
            input_comentario = input;
        }
        if (input.name === "btn_salvar_campo") {
            btn_comentario = input;
        }
    }
    btn_comentario.style.display = "none";

    XHR.addEventListener('load', function(event) {
        console.log(event);
        input_comentario.value = "";
        btn_comentario.style.display = "inline-block";
    });

    XHR.addEventListener('error', function(event) {
        alert('Não foi possivel enviar a anotação');
        btn_comentario.style.display = "inline-block";
    });

    XHR.open('POST', form.action);
    XHR.send(FD);

    //baixar anotacoes dnv
    buscar_anotacoes_js(id_campo, function(texto) {
        anotacoes.innerHTML = texto;
    });
}

function deletar_anotacao(id) {
    document.getElementById("anotacao_" + id).style.display = "none";
    let form = document.getElementById("form_deletar_anotacao_" + id);

    //submit
    const XHR = new XMLHttpRequest();
    const FD = new FormData();

    let urlEncodedDataPairs = [];
    for (let input of form.querySelectorAll("input")) {
        FD.append(input.name, input.value);
    }

    XHR.open('POST', form.action);
    XHR.send(FD);
}

function add_id_na_subsecao(id) {
    document.getElementById("secao_id").value = id;
}





