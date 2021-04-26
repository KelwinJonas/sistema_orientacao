<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papel extends Model
{
    public const PROPRIETARIO = "proprietario";
    public const LEITOR = "leitor";
    public const EDITOR = "editor";
    use HasFactory;
}
