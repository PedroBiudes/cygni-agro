<?php

namespace App\Repositories\Interfaces;

interface PlayerInterface
{
    public function CreateUser($user);

    public function UserExists($email);

    public function FindUsers();

    public function UpdateUserExist($userExist);
}
