<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'Player';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $fillable = [
        'Id',
        'Nome',
        'Cpf',
        'Email',
        'Password',
        'DataNascimento',
        'AdicionadoEm',
        'Score'
    ];
}