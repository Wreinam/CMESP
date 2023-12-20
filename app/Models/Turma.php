<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantidade_vagas',
        'nivel',
        'dias_semana',
        'horario',
        'data_inicio',
        'data_termino',
        'idade_min_max',
        'endereco_id',
        'professor_id',
        'modalidade_id',
    ];

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'modalidade_id');
    }
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }
    
    public function matriculas()
    {
        return $this->belongsToMany(User::class, 'matriculas', 'turma_id', 'aluno_id');
    }

    public function aula()
    {
        return $this->belongsToMany(Aula::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'lista_espera', 'turma_id', 'aluno_id');
    }
}
