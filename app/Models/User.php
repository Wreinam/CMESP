<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'cpf',
        'permissao',
        'password',
        'imagem_perfil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_informacoe(){
        return $this->hasOne(User_informacoe::class);
    }
    public function user_estuda(){
        return $this->hasOne(User_estuda::class);
    }
    public function responsavel_dados(){
        return $this->hasOne(Responsavel_dado::class);
    }
    public function user_anamnese(){
        return $this->hasOne(Anamnese::class, 'aluno_id');
    }



    public function turmasProfessor(){
        return $this->hasOne(Turma::class, 'professor_id');
    }

    public function matriculas(){
        return $this->hasOne(Matricula::class, 'aluno_id');
    }

    

    public function turmas(){
        return $this->belongsToMany(Turma::class, 'lista_espera', 'aluno_id', 'turma_id');
    }

}
