<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'dia_semana',
        'turma_id',
        'status',
        'justificativa',
    ];

    public function turma(){
        return $this->hasMany(Turma::class, 'turma_id');
    }
}
