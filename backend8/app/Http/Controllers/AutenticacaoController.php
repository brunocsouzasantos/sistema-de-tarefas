<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Util;
use App\Models\User;
use JWTAuth;

class AutenticacaoController extends Controller
{
    protected $util;

    public function __construct(Util $util){
        $this->util = $util;
    }

    public function login(Request $request)
    {
        $dataForm = $request->only('email', 'password');
        $this->util->logDebug($dataForm);
        $usuario = User::where('email', $request->email )->first();
        $token = null;

        if (!$token = JWTAuth::attempt($dataForm)) {
            return $this->util->jsonMessage('error', 'Usuário e/ou Senha incorretos.', 401);
        }
        try {
            $usuario = JWTAuth::user();
            return response()->json([
                'success' => true,
                'nome' => $usuario->name,
                'email' => $usuario->email,
                'permissao' => $usuario->permissao,
                'token' => $token,
                'message' => 'Usuario autenticado com sucesso.'
            ]);
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro no login.', 500);
        }
    }
}
