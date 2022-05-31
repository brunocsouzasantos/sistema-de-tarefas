<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailUserObserver;

use Illuminate\Support\Facades\Log;
use App\Models\User;

class Util extends Controller
{
    public function logDebug($msg){
        Log::debug($msg);
    }

    public function verificaEmailCadastrado($email, $id = 0)
    {   
        $usuario = User::where('email', $email)->first();
        if(isset($usuario->id) && ($usuario->id !== $id)){ 
            return true;
        }
        return false;
    }

    public function validaRelacionamentosNaExclusao($model,$id)
    {
      $objeto = $model->with($model->relationships)->find($id);
      $nomeNamespace = get_class($objeto);
      $nomeClasse = substr($nomeNamespace, strrpos($nomeNamespace, '\\')+1);
      $validacao=array("isInvalido"=>false,"msg"=>'');

      foreach ($objeto->getRelations() as $key => $value) {
        if(!empty($value) && !empty($value->first())) {
          $validacao["isInvalido"] = true;
          $validacao["msg"].="$nomeClasse não foi deletado pois possui vinculos com $key.<br/>";
        }
      }
      return $validacao;
    }

    public function jsonMessage($type, $msg, $code)
    {
        $type = $type === 'success' ? 'true' : 'false';
        return response()->json([
            'success' => $type, 'message' => $msg
        ], $code);
    }

    public function dipararEmailUserObserver($msg, $user)
    {
        try {
            $dados['titulo'] = $msg;
            $dados['nome'] = $user->name;
            $dados['email'] = $user->email;
            Mail::to('teste@teste.com')->send(new SendMailUserObserver($dados));
        } catch (\Exception $e) {
            return $this->util->jsonMessage('error', 'Erro ao enviar e-mail de log.', 500);
        }
    }
}
