<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papel extends Model
{
    public const PROPRIETARIO = "proprietario"; // Pode no maximo tudo
    public const GERENTE_DE_CONTEUDO = "gerente"; // Pode no maximo criar, editar e mover seções e campos
    public const EDITOR = "editor"; // Pode no maximo preencher os campo
    public const LEITOR = "leitor"; // Pode só fazer anotações/comentarios

    public const PAPEIS = [
        "Gerente de Conteúdo" => Papel::GERENTE_DE_CONTEUDO,
        "Editor" => Papel::EDITOR,
        "Leitor" => Papel::LEITOR,
    ];


    public const PAPEIS_COMPLETO = [
        "Proprietário" => Papel::PROPRIETARIO,
        "Gerente de Conteúdo" => Papel::GERENTE_DE_CONTEUDO,
        "Editor" => Papel::EDITOR,
        "Leitor" => Papel::LEITOR,
    ];


    use HasFactory;
}
