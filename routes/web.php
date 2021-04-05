<?php

use App\Http\Controllers\AtividadeAcademicaController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\UserController;
use App\Models\AtividadeAcademica;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Faker\Guesser\Name;

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

Route::get('/login/google', [LoginController::class, 'redirectToGoogleProvider'])->name('loginGoogle');
Route::get('/login/google/callback',[LoginController::class,'handleProviderGoogleCallback']);

Route::get('redefinir_senha', [UserController::class, 'redefinirSenha'])->name('redefinirSenha');

Route::prefix('/cadastrar_instituicao')->name('cadastrarInstituicao')->group(function (){
    Route::get('/', [InstituicaoController::class, 'cadastroInstituicao']);
    Route::post('/salvar', [InstituicaoController::class, 'salvarCadastrarInstituicao'])->name('.salvar');
});

Route::prefix('cadastrar_usuario')->name('cadastrarUsuario')->group(function(){
    Route::get('/', [UserController::class, 'cadastroUsuario']);
    Route::post('/salvar', [UserController::class, 'salvarCadastrarUsuario'])->name('.salvar');
});

//Ajeitar essa rota (deixar apenas a /salvar)
Route::prefix('cadastrar_atividade')->name('cadastrarAtividade')->group(function(){
    // Route::get('/', [AtividadeAcademicaController::class, 'cadastroAtividade']);
    Route::post('/salvar', [AtividadeAcademicaController::class, 'salvarCadastrarAtividade'])->name('.salvar');
});

Route::get('/listar_atividades', [AtividadeAcademicaController::class, 'listarAtividades'])->name('listarAtividades');
#Route::get('/ver_atividade/{atividade_id}', [AtividadeAcademicaController::class, 'verAtividade'])->name('verAtividade');

Route::prefix('ver_atividade/{atividade_id}')->name('verAtividade')->group(function(){
    Route::get('/mural', [AtividadeAcademicaController::class, 'verAtividade'])->name('.verMural');
    Route::get('/secoes', [AtividadeAcademicaController::class, 'verSecoes'])->name('.verSecoes');
    Route::get('/arquivos', [AtividadeAcademicaController::class, 'verArquivos'])->name('.verArquivos');
    Route::get('/pessoas', [AtividadeAcademicaController::class, 'verPessoas'])->name('.verPessoas');
});

Route::post('/salvar_secao', [SecaoController::class, 'salvarAdicionarSecao'])->name('salvarSecao');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
