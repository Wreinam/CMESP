<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_informacoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomeMae',
        'nomePai',
        'dataNascimento',
        'rg',
        'rgFrente',
        'rgVerso',
        'telefone',
        'telefoneEmergencia',
        'endereco',
        'bairro',
        
        
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
