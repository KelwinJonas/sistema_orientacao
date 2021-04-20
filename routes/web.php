<?php

use App\Http\Controllers\AtividadeAcademicaController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CampoController;
use App\Models\Campo;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login/google', [LoginController::class, 'redirectToGoogleProvider'])->name('loginGoogle');
Route::get('/login/google/callback', [LoginController::class, 'handleProviderGoogleCallback']);

Route::get('redefinir_senha', [UserController::class, 'redefinirSenha'])->name('redefinirSenha');

Route::prefix('/cadastrar_instituicao')->name('cadastrarInstituicao')->group(function () {
    Route::get('/', [InstituicaoController::class, 'cadastroInstituicao'])->middleware('auth');
    Route::post('/salvar', [InstituicaoController::class, 'salvarCadastrarInstituicao'])->name('.salvar')->middleware('auth');
});

Route::prefix('cadastrar_usuario')->name('cadastrarUsuario')->group(function () {
    Route::get('/', [UserController::class, 'cadastroUsuario']);
    Route::post('/salvar', [UserController::class, 'salvarCadastrarUsuario'])->name('.salvar');
});

//Ajeitar essa rota (deixar apenas a /salvar)
Route::prefix('cadastrar_atividade')->name('cadastrarAtividade')->group(function () {
    // Route::get('/', [AtividadeAcademicaController::class, 'cadastroAtividade']);
    Route::post('/salvar', [AtividadeAcademicaController::class, 'salvarCadastrarAtividade'])->name('.salvar')->middleware('auth');
});

Route::get('/listar_atividades', [AtividadeAcademicaController::class, 'listarAtividades'])->name('listarAtividades')->middleware('auth');
//Route::get('/ver_atividade/{atividade_id}', [AtividadeAcademicaController::class, 'verAtividade'])->name('verAtividade');


Route::middleware('auth')->group(function () {
    Route::prefix('ver_atividade/{atividade_id}')->name('verAtividade')->group(function () {
        Route::get('/mural', [AtividadeAcademicaController::class, 'verAtividade'])->name('.verMural');
        Route::get('/secoes/{secao_atual?}', [AtividadeAcademicaController::class, 'verSecoes'])->name('.verSecoes');
        Route::get('/arquivos', [AtividadeAcademicaController::class, 'verArquivos'])->name('.verArquivos');
        Route::get('/pessoas', [AtividadeAcademicaController::class, 'verPessoas'])->name('.verPessoas');
    });

    Route::post("/salvar_campo", [CampoController::class, 'salvarCampo'])->name('salvarCampo');
    Route::post("/deletar_campo", [CampoController::class, 'deletarCampo'])->name('deletarCampo');

    Route::post('/deletar_secao', [SecaoController::class, 'deletarSecao'])->name('deletarSecao');
    Route::post('/salvar_secao', [SecaoController::class, 'salvarAdicionarSecao'])->name('salvarSecao');
    Route::post('/salvar_editar_secao', [SecaoController::class, 'salvarEditarSecao'])->name('salvarEditarSecao');

    Route::get('/anotacoes/{id_campo}', [CampoController::class, 'anotacoes_html'])->name('anotacoes');
    Route::post('/anotacoes/salvar', [CampoController::class, 'salvar_anotacao'])->name('anotacoes.salvar');
    Route::post('/anotacoes/deletar', [CampoController::class, 'deletar_anotacao'])->name('anotacoes.deletar');

    Route::post('/salvar_conteudo_campo', [CampoController::class, 'salvar_conteudo'])->name('salvarConteudo');

    Route::post('/salvar_ordenar_secao', [SecaoController::class, 'salvar_ordenar_secao'])->name('editarOrdemSecao');
    Route::post('/salvar_subsecionamento', [SecaoController::class, 'salvar_subsecionar_secao'])->name('subsecionarSecao');
});
