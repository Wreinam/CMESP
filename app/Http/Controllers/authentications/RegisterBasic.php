<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Responsavel_dado;
use Illuminate\Http\Request;
use App\Models\User_informacoe;
use App\Models\User;
use App\Models\User_estuda;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Bairro;

class RegisterBasic extends Controller
{
  public function index()
  {
    $bairros = Bairro::pluck('nome');
    return view('content.authentications.auth-register-basic', compact('bairros'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nome_aluno' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed', // Confirmação de senha
    ]);

    if ($validator->fails()) {
      return redirect('register')
        ->withErrors($validator)
        ->withInput();
    }
    $idade = $this->calcularIdadeAPartirDaData($request->data_nascimento);

    $user = new User();
    $user->name = $request->nome_aluno;
    $user->email = $request->email;
    $user->cpf = preg_replace('/[^0-9]/', '', $request->cpf_aluno);
    $user->password = Hash::make($request->password);
    $user->save();

    $alunoDados = new User_informacoe();
    $alunoDados->nomeMae = $request->nome_mae;
    $alunoDados->nomePai = $request->nome_pai;
    $alunoDados->dataNascimento = $request->data_nascimento;
    $alunoDados->idade = $idade;

    $alunoDados->rg = $request->rg_aluno;

    $rg_aluno_frente_image_name = md5($request->rg_aluno_frente->getClientOriginalName() . strtotime('now')) . "." . $request->rg_aluno_frente->extension();
    $alunoDados->rgFrente = $rg_aluno_frente_image_name;
    $request->rg_aluno_frente->move(public_path('assets/img/rg_aluno'), $rg_aluno_frente_image_name);

    $rg_aluno_verso_image_name = md5($request->rg_aluno_verso->getClientOriginalName() . strtotime('now')) . "." . $request->rg_aluno_verso->extension();
    $alunoDados->rgVerso = $rg_aluno_verso_image_name;
    $request->rg_aluno_verso->move(public_path('assets/img/rg_aluno'), $rg_aluno_verso_image_name);

    $alunoDados->telefone = $request->telefone;
    $alunoDados->telefoneEmergencia = $request->telefone_emergencia;
    $alunoDados->endereco = $request->endereco . ' ' . $request->numero;
    $alunoDados->bairro = $request->bairro;
    $alunoDados->user_id = $user->id;

    $alunoDados->save();

    if ($request->estudaInput == "true") {
      $userEstuda = new User_estuda();
      $userEstuda->nomeEscola = $request->nome_escola;
      $userEstuda->serie = $request->serie;
      $userEstuda->periodo = $request->periodo;
      $userEstuda->user_id = $user->id;
      $userEstuda->save();
    }

    if ($request->maiorIdadeInput == "false") {
      $responsavelDado = new Responsavel_dado();
      $responsavelDado->grauParentesco = $request->parentesco;
      $responsavelDado->nomeResponsavel = $request->nome_responsavel;
      $responsavelDado->cpfResponsavel = $request->cpf_responsavel;
      $responsavelDado->rgResponsavel = $request->rg_responsavel;

      $rg_responsavel_frente_image_name = md5($request->rg_responsavel_frente->getClientOriginalName() . strtotime('now')) . "." . $request->rg_responsavel_frente->extension();
      $responsavelDado->rgFrenteResponsavel = $rg_responsavel_frente_image_name;
      $request->rg_responsavel_frente->move(public_path('assets/img/rg_responsavel'), $rg_responsavel_frente_image_name);
      
      $rg_responsavel_verso_image_name = md5($request->rg_responsavel_verso->getClientOriginalName() . strtotime('now')) . "." . $request->rg_responsavel_verso->extension();
      $responsavelDado->rgVersoResponsavel = $rg_responsavel_verso_image_name;
      $request->rg_responsavel_verso->move(public_path('assets/img/rg_responsavel'), $rg_responsavel_verso_image_name);

      $responsavelDado->user_id = $user->id;
      $responsavelDado->save();
    }

    return redirect('/');
  }

  private function calcularIdadeAPartirDaData($dataNascimento)
  {
    // Verificar se a data de nascimento é válida
    $dataNascimento = \DateTime::createFromFormat('Y-m-d', $dataNascimento);

    if (!$dataNascimento) {
      // Lida com o caso em que a data de nascimento é inválida
      return 'Data de nascimento inválida';
    }

    // Calcular a diferença entre a data de nascimento e a data atual
    $hoje = new \DateTime();
    $diferenca = $hoje->diff($dataNascimento);

    // Retornar a idade
    return $diferenca->y;
  }
}
