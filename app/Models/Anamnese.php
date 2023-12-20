<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnese extends Model
{
    use HasFactory;
    protected $fillable = [
        'cardiaco',
        'alergia',
        'osseo',
        'doenca',
        'tratamento',
        'medicamento',
        'fumante',
        'diabetico',
        'insulina',
        'pressao',
        'nadar',
        'aluno_id',
        
    ];
}
