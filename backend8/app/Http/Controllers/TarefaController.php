<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Http\Controllers\Util;
use App\Http\Requests\CreateUpdateTarefaRequest;

class TarefaController extends Controller
{

    protected $util;

    public function __construct(Util $util)
    {
        $this->util = $util;
    }

    public function listarTarefas($tipoFiltroTarefas)
    {
        $usuario = JWTAuth::parseToken()->authenticate();
        try {
            if ($tipoFiltroTarefas === "TO") {
                return Tarefa::where('user_id', $usuario->id)
                            ->get();
            }
            if($usuario->permissao === 'USR') {
                return Tarefa::where('status', $tipoFiltroTarefas)
                            ->where('user_id', $usuario->id)
                            ->get();
            }
            if($usuario->permissao === 'ADM') {
                return Tarefa::where('status', $tipoFiltroTarefas)
                            ->get();
            }
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error','Erro ao listar tarefas.', 500);
        }
    }

    public function cadastrarTarefa(CreateUpdateTarefaRequest $request)
    {
        $usuario = JWTAuth::parseToken()->authenticate();
        try {
            Tarefa::create([
                $request->validated(),
                'user_id' => $usuario->id,
                'nome' => $request->nome,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'status' => 'PE',
            ]);
            return $this->util->jsonMessage('success','Tarefa cadastrada com sucesso.', 201);
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao cadastrar nova tarefa.', 500);
        }
    }

    public function atualizarTarefa(CreateUpdateTarefaRequest $request)
    {
        $tarefa = Tarefa::findOrFail($request->id);
        try {
           $tarefa->update($request->validated());
           return $this->util->jsonMessage('success', 'Tarefa atualizada com sucesso.', 200);
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao atualizar tarefa.', 500);

        }
    }

    public function deletarTarefa($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        try {
            $tarefa->delete();
            return $this->util->jsonMessage('success', 'Tarefa deletada com sucesso.', 200);
         } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao deletar tarefa.', 500);

         }
    }

    public function atualizarStatusTarefa(Request $request)
    {
        $dataForm = $request->all();
        $tarefa = Tarefa::findOrFail($dataForm['id']);
        $tarefa->status = $dataForm['status'] === 'PE' ? 'CO' : 'PE';
        try {
            $this->util->logDebug($tarefa);
            $tarefa->update();
            return response()->json([
                'success' => true,
                'message' => 'Status da tarefa atualizado com sucesso.',
                'type' => $tarefa->status
            ], 200);
         } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao concluir tarefa.', 500);
         }
    }
}
