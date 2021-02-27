<?php

use App\Http\Controllers\AtividadeAcademicaController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\UsuarioController;
use App\Models\AtividadeAcademica;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::prefix('/cadastrar_instituicao')->name('cadastrarInstituicao')->group(function (){
    Route::get('/', [InstituicaoController::class, 'cadastroInstituicao']);
    Route::post('/salvar', [InstituicaoController::class, 'salvarCadastrarInstituicao'])->name('.salvar');
});

Route::prefix('cadastrar_usuario')->name('cadastrarUsuario')->group(function(){
    Route::get('/', [UsuarioController::class, 'cadastroUsuario']);
    Route::post('/salvar', [UsuarioController::class, 'salvarCadastrarUsuario'])->name('.salvar');
});

Route::prefix('cadastrar_atividade')->name('cadastrarAtividade')->group(function (){
    Route::get('/', [AtividadeAcademicaController::class, 'cadastroAtividade']);
    Route::post('/salvar', [AtividadeAcademicaController::class, 'salvarCadastrarAtividade']);
});