<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamada extends Model
{
    use HasFactory;

    protected $fillable = [
        'aula_id',
        'aluno_id',
        'presenca',
        'justificativa',
        
    ];
}
