<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AutenticacaoController,
    UsuarioController,
    TarefaController,
    Util
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
#Rota de Acesso

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    #Rota de Acesso
    Route::post('/login', [AutenticacaoController::class, 'login']);
    
    #JWT Authentication
    Route::group(['middleware' => 'auth.jwt'], function () {
        #Rotas Gerenciar Usuários
        Route::get('/listar_usuarios', [UsuarioController::class, 'listarUsuarios']);
        Route::post('/cadastrar_usuario', [UsuarioController::class, 'cadastrarUsuario']);
        Route::put('/atualizar_usuario', [UsuarioController::class, 'atualizarUsuario']);
        Route::delete('/deletar_usuario/{id}', [UsuarioController::class, 'deletarUsuario']);

        #Rotas Tarefas
        Route::get('/listar_tarefas/{tipoFiltroTarefas}', [TarefaController::class, 'listarTarefas']);
        Route::post('/cadastrar_tarefa', [TarefaController::class, 'cadastrarTarefa']);
        Route::put('/atualizar_tarefa', [TarefaController::class, 'atualizarTarefa']);
        Route::delete('/deletar_tarefa/{id}', [TarefaController::class, 'deletarTarefa']);
        Route::put('/atualizar_status_tarefa', [TarefaController::class, 'atualizarStatusTarefa']);

        #Rodas Reuso
        Route::post('/verifica_email_cadastrado', [Util::class, 'verificaEmailCadastrado']);
    });
});
