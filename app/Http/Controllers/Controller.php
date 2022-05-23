<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Interfaces\PlayerInterface;
use Laravel\Lumen\Routing\Controller as BaseController;
use DateTime;
use App\Models\Player;


class Controller extends BaseController
{
    
    protected $interface;

    public function __construct(
        PlayerInterface $playerInterface
    ) {
        $this->interface = $playerInterface;
    }
    public function CreateUser(Request $request){
        try {
            $date = new DateTime();

            //Valida se o usuário já existe para o email informado
            if($this->interface->UserExists($request->Email))
                return response()->json("Já existe um usuário cadastrado com o e-mail informado", Response::HTTP_INTERNAL_SERVER_ERROR);

            $cpfTratado = str_replace("-", "", $request->Cpf);
            $cpfTratado = str_replace(".", "", $cpfTratado);
            
            //Cria um array com os dados a ser inserido no usuário
            $newPlayer = new Player ([
                "Nome" => $request->Nome,
                "Cpf" => $cpfTratado,
                "Email" => $request->Email != null ? $request->Email : $cpfTratado,
                "Password" => $request->Password,
                "DataNascimento" => $request->DataNascimento->format("Y-m-d H:i:s"),
                "AdicionadoEm" => $date->format("Y-m-d H:i:s"),
                "Score" => $request->score
            ]); 

            //Insere o novo usuário no banco de dados e retorna
            $user = $this->interface->CreateUser($newPlayer);
            
            return response()->json($user, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            $exception = [
                'Message' => $ex->getMessage(),
                'Code' => $ex->getCode(),
                'Trace' => $ex->getTraceAsString(),
                'Exception' => $ex->__toString()
            ];
            
            return response()->json($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function ListUser(){
        try {
            $users = $this->interface->FindUsers();
            
            return response()->json($users, Response::HTTP_OK);
        } catch (\Exception $ex) {
            $exception = [
                'Message' => $ex->getMessage(),
                'Code' => $ex->getCode(),
                'Trace' => $ex->getTraceAsString(),
                'Exception' => $ex->__toString()
            ];
            
            return response()->json($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function UpdateUser($id = null, Request $request)
    {
        try {
            $date = new DateTime();

            //Valida se o usuário já existe para o email informado
            $userExist = $this->interface->UserExists($id);

            $cpfTratado = str_replace("-", "", $request->Cpf);
            $cpfTratado = str_replace(".", "", $cpfTratado);
            
            //Cria um array com os dados a ser inserido no usuário
            $userExist->Nome = $request->Nome;
            $userExist->Cpf = $cpfTratado;
            $userExist->Email = $request->Email != null ? $request->Email : $cpfTratado;
            $userExist->Password = $request->Password;
            $userExist->DataNascimento = $request->DataNascimento->format("Y-m-d H:i:s");
            $userExist->Score =$request->score;

            //Insere o novo usuário no banco de dados e retorna
            $user = $this->interface->UpdateUserExist($userExist);
            
            return response()->json($user, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            $exception = [
                'Message' => $ex->getMessage(),
                'Code' => $ex->getCode(),
                'Trace' => $ex->getTraceAsString(),
                'Exception' => $ex->__toString()
            ];
            
            return response()->json($exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
