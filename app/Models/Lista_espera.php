<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista_espera extends Model
{
    use HasFactory;

    protected $table = 'lista_espera';

    protected $fillable = [
        'id',
        'aluno_id',
        'turma_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
    
}