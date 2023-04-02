<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Util;

class UsuarioController extends Controller
{
    protected $util;

    public function __construct(Util $util)
    {
        $this->util = $util;
    }

    public function listarUsuarios()
    {
        try {
            return User::all();
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao listar usuários.', 500);
        }
    }

    public function cadastrarUsuario(Request $request)
    {
        $dataForm = $request->all();
        $isEmailCadastrado = $this->util->verificaEmailCadastrado($dataForm['email']);
        if ($isEmailCadastrado) {
            return $this->util->jsonMessage('error', 'E-mail já cadastrado para outro usuário.', 409);
        }
        try {
           User::create([
                'name' => $dataForm['name'],
                'email' => $dataForm['email'],
                'password' => bcrypt($dataForm['password']),
                'permissao' => 'USR'
            ]);
            return $this->util->jsonMessage('success', 'Usuário cadastrado com sucesso.', 201);
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao cadastrar novo usuário.', 500);
        }
    }

    public function atualizarUsuario(Request $request)
    {
        $dataForm = $request->all();
        $isEmailCadastrado = $this->util->verificaEmailCadastrado($dataForm['email'], $dataForm['id']);
        if ($isEmailCadastrado) {
            return $this->util->jsonMessage('error', 'E-mail já cadastrado para outro usuário.', 409);
        }
        $usuario = User::findOrFail($dataForm['id']);
        try {
            $usuario->update($dataForm);
            return $this->util->jsonMessage('success', 'Usuário atualizado com sucesso.', 200);
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao atualizar usuário.', 500);
        }
    }

    public function deletarUsuario($id)
    {
        $validaRelacionamentos = $this->util->validaRelacionamentosNaExclusao(new User,$id);
        if($validaRelacionamentos["isInvalido"]){
            return $this->util->jsonMessage('error', $validaRelacionamentos["msg"], 500);
        }
        $usuario = User::findOrFail($id);
        try {
            $usuario->delete();
            return $this->util->jsonMessage('success', 'Usuário deletado com sucesso.', 200);
         } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao deletar usuário.', 500);
         }
    }
}
