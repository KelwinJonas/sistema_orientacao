<?php

use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\AtividadeAcademicaController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CampoController;
use App\Http\Controllers\PessoaController;
use App\Http\Middleware\MembroAtividade;
use App\Models\Instituicao;
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



Route::prefix('/instituicoes')->name('instituicao')->group(function () {
    Route::get('/', [InstituicaoController::class, 'listarInstituicoes'])->name('.listar');
    Route::get('/ver/{id}', [InstituicaoController::class, 'verInstituicao'])->name('.ver');
    Route::get('/nova', [InstituicaoController::class, 'cadastroInstituicao'])->name('.nova');
    Route::post('/salvar', [InstituicaoController::class, 'salvarCadastrarInstituicao'])->name('.salvar');
    Route::post('/instituicoes/salvar/editar', [InstituicaoController::class, 'salvarEditarInstituicao'])->name('.editar.salvar');    
    Route::post('/deletar', [InstituicaoController::class, 'deletarInstituicao'])->name('.deletar');
    Route::get('/template/ver/{id}', [InstituicaoController::class, 'verTemplate'])->name('.template.ver');
    Route::get('/template/novo/{id}', [InstituicaoController::class, 'novoTemplate'])->name('.template.novo');
    Route::post('/template/salvar', [InstituicaoController::class, 'salvarTemplate'])->name('.template.salvar');
    Route::post('/template/editar/salvar', [InstituicaoController::class, 'salvarEditarTemplate'])->name('.template.editar.salvar');
    Route::post('/template/deletar', [InstituicaoController::class, 'deletarTemplate'])->name('.template.deletar');
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

Route::post('/salvarEditarAtividade/{atividade_id}', [AtividadeAcademicaController::class, 'salvarEditarAtividade'])->name('salvarEditarAtividade')->middleware('auth');
Route::post('/deletarAtividade', [AtividadeAcademicaController::class, 'deletarAtividade'])->name('deletarAtividade')->middleware('auth');

Route::get('/listar_atividades', [AtividadeAcademicaController::class, 'listarAtividades'])->name('listarAtividades')->middleware('auth');
//Route::get('/ver_atividade/{atividade_id}', [AtividadeAcademicaController::class, 'verAtividade'])->name('verAtividade');


Route::middleware('auth')->group(function () {

    Route::middleware(MembroAtividade::class)->group(function () {
        Route::prefix('ver_atividade/{atividade_id}')->name('verAtividade')->group(function () {
            Route::get('/mural', [AtividadeAcademicaController::class, 'verAtividade'])->name('.verMural');
            Route::get('/secoes/{secao_atual?}', [AtividadeAcademicaController::class, 'verSecoes'])->name('.verSecoes');
            Route::get('/arquivos', [AtividadeAcademicaController::class, 'verArquivos'])->name('.verArquivos');
            Route::get('/pessoas', [AtividadeAcademicaController::class, 'verPessoas'])->name('.verPessoas');
            Route::post('/salvarAdicionarPessoa', [PessoaController::class, 'salvarAdicionarPessoa'])->name('.salvarAdicionarPessoa');
            Route::post('/removerPessoa', [PessoaController::class, 'removerPessoa'])->name('.removerPessoa');
            Route::post('/editarPessoa', [PessoaController::class, 'editarPessoa'])->name('.salvarEditarPessoa');
        });
    });

    Route::post("/salvar_editar_arquivo", [ArquivoController::class, 'salvarEditarArquivo'])->name('salvarEditarArquivo');
    Route::post("/deletar_arquivo", [ArquivoController::class, 'deletarArquivo'])->name('deletarArquivo');

    Route::post("/salvar_campo", [CampoController::class, 'salvarCampo'])->name('salvarCampo');
    Route::post("/deletar_campo", [CampoController::class, 'deletarCampo'])->name('deletarCampo');

    Route::get('/arvore_secao/{id_atividade}/{id_secao}', [SecaoController::class, 'arvore_secao_html'])->name('arvoreSecoes');
    Route::post('/deletar_secao', [SecaoController::class, 'deletarSecao'])->name('deletarSecao');
    Route::post('/salvar_secao', [SecaoController::class, 'salvarAdicionarSecao'])->name('salvarSecao');
    Route::post('/salvar_editar_secao', [SecaoController::class, 'salvarEditarSecao'])->name('salvarEditarSecao');
    Route::post('/gerar_secao_template', [SecaoController::class, 'salvarSecaoTemplate'])->name('salvarSecaoTemplate');

    Route::get('/anotacoes/{id_campo}', [CampoController::class, 'anotacoes_html'])->name('anotacoes');
    Route::post('/anotacoes/salvar', [CampoController::class, 'salvar_anotacao'])->name('anotacoes.salvar');
    Route::post('/anotacoes/deletar', [CampoController::class, 'deletar_anotacao'])->name('anotacoes.deletar');

    Route::post('/salvar_conteudo_campo', [CampoController::class, 'salvar_conteudo'])->name('salvarConteudo');

    Route::post('/salvar_ordenar_secao', [SecaoController::class, 'salvar_ordenar_secao'])->name('editarOrdemSecao');
    Route::post('/salvar_subsecionamento', [SecaoController::class, 'salvar_subsecionar_secao'])->name('subsecionarSecao');
});

Route::post('/uploadArquivo/{atividade_id}', [ArquivoController::class, 'uploadFile'])->name('uploadArquivo');

Route::post('/salvar_novo_modelo', [UserController::class, 'salvar_novo_modelo'])->name('user.template.salvar');
Route::post('/salvar_editar_modelo', [UserController::class, 'salvar_editar_modelo'])->name('user.template.editar.salvar');
Route::get('/meus_modelos', [UserController::class, 'modelos_pessoais'])->name('templates.pessoais');
Route::post('/salvar_modelo_pessoal', [UserController::class, 'salvar_modelos_pessoais'])->name('templates.pessoais.salvar');
Route::post('/deletar_modelo_pessoal', [UserController::class, 'deletar_modelo_pessoais'])->name('templates.pessoais.deletar');
Route::get('/modelo_pessoal/novo', [UserController::class, 'novo_modelo'])->name('templates.pessoais.novo');
Route::get('/modelo_pessoal/{id}', [UserController::class, 'ver_modelo'])->name('templates.pessoais.ver');
