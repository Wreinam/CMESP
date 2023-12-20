<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'aluno_id',
        'turma_id',
        'faltas',
        'status'
    ];
    
    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }
    
    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'modalidade_id');
    }
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function aluno()
    {
        return $this->belongsTo(User::class);
    }
}
