<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PlayerInterface;
use App\Models\Player;
use App\Functions\Pagination;
use Illuminate\Support\Facades\DB;

//Camada de repositório, unica que deverá fazer buscas e alterações no banco de dados
class PlayerRepository implements PlayerInterface
{
    protected $model;

    public function __construct(Player $player)
    {
        $this->model = $player;
    }

    public function CreateUser($user)
    {
        $user->save();
        return $user;
    }
    
    public function UserExists($email)
    {
        return $this->model->where('Email', '=', $email)->exists();
    }

    public function FindUsers()
    {
        return $this->model;
    }
    public function UpdateUserExist($userExist)
    {
        $userExist->save();
        return $userExist;
    }
}