// Arvore dos templates

let span_edit_secao_campo_selecionado;

function esconder_contextos() {
    document.getElementById("menu_contexto_edit_secao_campo").style.display = "none";
    document.getElementById("menu_contexto_secao").style.display = "none";
    document.getElementById("menu_contexto_campo").style.display = "none";
}


function str_no(tipo_no, titulo_no, callback_preenchimento) {
    return "<div class='arvore_secao' tipo='" + tipo_no + "' titulo='" + titulo_no + "'><span>" + titulo_no + "</span>" + callback_preenchimento() + "</div>";
}

function str_novo_no(tipo_no) {
    return str_no(tipo_no, "Novo", function() {
        return "";
    });
}

function remover_no_arvore() {
    span_edit_secao_campo_selecionado.parentNode.remove();
}

function add_subsecao() {
    raiz_no = span_edit_secao_campo_selecionado.parentNode;
    raiz_no.innerHTML += str_novo_no('secao');
    carregar_arvore_secao_edits();
}

function add_campo() {
    raiz_no = span_edit_secao_campo_selecionado.parentNode;
    raiz_no.innerHTML += str_novo_no('campo');
    carregar_arvore_secao_edits();
}

function preparar_editar_no_arvore() {
    let raiz_arvore = span_edit_secao_campo_selecionado;

    while (!raiz_arvore.classList.contains("no_raiz")) {
        raiz_arvore = raiz_arvore.parentNode;
    }

    form = raiz_arvore.parentNode;
    let input_edit = form.querySelector("#titulo_campo_secao");
    input_edit.querySelector("#texto_titulo").value = span_edit_secao_campo_selecionado.innerHTML;
    input_edit.style.display = "block";
}

function carregar_arvore_secao_edits() {
    Array.from(document.getElementsByClassName('arvore_secao')).forEach((el) => {
        let span_filho = el.querySelector("span");
        span_filho.onclick = function() {
            span_edit_secao_campo_selecionado = this;
            preparar_editar_no_arvore();
        };

        span_filho.oncontextmenu = function(evt) {
            evt.preventDefault();

            let no_arvore = this.parentNode;
            span_edit_secao_campo_selecionado = this;

            if (no_arvore.getAttribute("tipo") === "secao") {
                document.getElementById("menu_contexto_secao").style.display = "block";
            }

            if (no_arvore.getAttribute("tipo") === "campo") {
                document.getElementById("menu_contexto_campo").style.display = "block";
            }

            if (document.getElementById("menu_contexto_edit_secao_campo").style.display == "block") {
                esconder_contextos();
            } else {
                let menu = document.getElementById("menu_contexto_edit_secao_campo");
                menu.style.display = 'block';
                menu.style.left = evt.pageX + "px";
                menu.style.top = evt.pageY + "px";
            }
        };
    });
}

function salvar_edit_secao_campo(pai_do_input) {
    let novo_titulo = pai_do_input.querySelector("#texto_titulo").value;
    span_edit_secao_campo_selecionado.parentNode.setAttribute("titulo", novo_titulo);
    span_edit_secao_campo_selecionado.parentNode.querySelector("span").innerHTML = novo_titulo;
    span_edit_secao_campo_selecionado = undefined;
    pai_do_input.style.display = "none";
}

function add_no_raiz(pai_arvore, tipo_no) {
    let raiz_arvore = pai_arvore.querySelector('.no_raiz');
    raiz_arvore.innerHTML += str_novo_no(tipo_no);
    carregar_arvore_secao_edits();
}

function carregar_scroll_menu_contexto() {
    Array.from(document.getElementsByClassName("modal_edit_template_c")).forEach((el) => {
        el.onscroll = function(evt) {
            let menu = document.getElementById("menu_contexto_edit_secao_campo");
            if (menu.style.display == "block") {
                esconder_contextos()
            }
        }
    });

}

function parser_arvore(no_arvore) {
    let tipo = no_arvore.getAttribute("tipo");
    let titulo = no_arvore.getAttribute("titulo");
    let filhos = [];

    for (let filho of no_arvore.children) {
        filhos.push(parser_arvore(filho));
    }

    return {
        tipo: tipo,
        titulo: titulo,
        filhos: filhos,
    };
}

function preparar_template_form(evt, form) {
    let arvore = form.querySelector(".no_raiz");
    Array.from(arvore.querySelectorAll("span")).forEach((el) => el.remove())
    let arr = [];
    for (let item of arvore.children) {
        arr.push(parser_arvore(item));
    }
    form.querySelector("#arr_template").value = JSON.stringify(arr);
    return true;
}


function gerar_arvore(raiz) {
    return str_no(raiz.tipo, raiz.titulo, function() {
        let str_ret = "";

        for (let filho of raiz.filhos) {
            str_ret += gerar_arvore(filho);
        }

        return str_ret;
    });
}

function montar_arvores() {
    let arvores = document.getElementsByClassName("no_raiz");
    for (let arvore of arvores) {
        let json = JSON.parse(arvore.getAttribute("dados_arvore"));
        for (let raiz of json) {
            arvore.innerHTML += gerar_arvore(raiz);
        }
    }
}


function preparar_exibicao_escolha_templates() {
                        document.getElementById('instituicao').onchange = function() {
                            document.getElementById("arvore_secao_template").innerHTML = "";
                            document.querySelectorAll(".templates_instituicoes").forEach((el) => {
                                el.style.display = "none";
                                el.querySelector("select").name = "";
                                el.querySelector("select").options.selectedIndex = 0;
                            });
                            let div_selecionado = document.getElementById(this.value);
                            div_selecionado.style.display = "block";
                            div_selecionado.querySelector("select").name = "template_id";
                        }

                        document.querySelectorAll(".selects-template").forEach((el) => {
                            el.onchange = function() {
                                let json_arvore_txt = el.options[el.options.selectedIndex].getAttribute("dados_arvore");
                                document.querySelector(".no_raiz").setAttribute("dados_arvore", json_arvore_txt);
                                document.getElementById("arvore_secao_template").innerHTML = "";
                                try {
                                    montar_arvores();
                                    document.getElementById("arvore_secao_template").innerHTML += "<br>";
                                } catch (ex) {
                                    document.getElementById("arvore_secao_template").innerHTML = "Template em branco";
                                }
                            };
                        });
}
