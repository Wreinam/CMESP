<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_informacoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Bairro;
use Twilio\Rest\Client;
use App\Models\Turma;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
  public function index()
  {

    
    
    return view('content.authentications.auth-login-basic');
  }
  public function deslogar(Request $request)
  {
    Auth::guard()->logout();
    $request->session()->invalidate();
    return redirect('/');
  }

  public function configuracao()
  {
    $user_informacao = User_informacoe::Where('user_id', auth()->user()->id)->first();
    $bairros = Bairro::pluck('nome');
    return view('content.pages.pagina-usuario', compact(['user_informacao', 'bairros']));
  }

  public function salvarConfiguracao(Request $request)
  {

    if (auth()->user()->permissao === 'Aluno') {
      $usuario = Auth::user();
      

      if($request->hasFile('imagem_perfil') && $request->file('imagem_perfil')->isValid()){
        $imageName = md5($request->imagem_perfil->getClientOriginalName() . strtotime('now')) . "." . $request->imagem_perfil->extension();
        $usuario->update([
          'imagem_perfil' => $imageName,
        ]);
        $request->imagem_perfil->move(public_path('assets/img/perfil/'), $imageName);
      }
      $usuario->update([
        'name' => $request->nome,
        'email' => $request->email,
        'cpf' => $request->cpf,

      ]);
      $user_informacao = User_informacoe::where('user_id', $usuario->id)->first();

      if($request->hasFile('rg_aluno_frente') && $request->file('rg_aluno_frente')->isValid()){
        $imageName = md5($request->rg_aluno_frente->getClientOriginalName() . strtotime('now')) . "." . $request->rg_aluno_frente->extension();
        $user_informacao->update([
          'rgFrente' => $imageName,
        ]);
        $request->rg_aluno_frente->move(public_path('assets/img/rg_aluno/'), $imageName);
      }

      if($request->hasFile('rg_aluno_verso') && $request->file('rg_aluno_verso')->isValid()){
        $imageName = md5($request->rg_aluno_verso->getClientOriginalName() . strtotime('now')) . "." . $request->rg_aluno_verso->extension();
        $user_informacao->update([
          'rgVerso' => $imageName,
        ]);
        $request->rg_aluno_verso->move(public_path('assets/img/rg_aluno/'), $imageName);
      }

      $user_informacao->update([
        'nomeMae' => $request->nomeMae,
        'nomePai' => $request->nomePai,
        'telefone' => $request->telefone,
        'telefoneEmergencia' => $request->telefoneEmergencia,
        'dataNascimento' => $request->dataNascimento,
        'endereco' => $request->endereco,
        'bairro' => $request->bairro,
        'rg' => $request->rg,
        
        

      ]);
    } else {
      $usuario = Auth::user();

      if($request->hasFile('imagem_perfil') && $request->file('imagem_perfil')->isValid()){
        $imageName = md5($request->imagem_perfil->getClientOriginalName() . strtotime('now')) . "." . $request->imagem_perfil->extension();
        $usuario->update([
          'imagem_perfil' => $imageName,
        ]);
        $request->imagem_perfil->move(public_path('assets/img/perfil/'), $imageName);
      }
      $usuario->update([
        'name' => $request->nome,
        'email' => $request->email,
      ]);
    }
    return redirect()->back();
  }


  public function auth(Request $request)
  {
    $user = User::where('email', $request->usuario)->orWhere('cpf', $request->usuario)->first();


    if ($user && Hash::check($request->password, $user->password)) {
      Auth::login($user);
      if ($user->permissao === 'Professor') {
        return redirect()->intended('dashboard/professor');
      } else if ($user->permissao === 'Aluno') {
        return redirect()->intended('dashboard/aluno');
      } else if ($user->permissao === 'Admin') {
        return redirect()->intended('dashboard/admin');
      } else {
        return redirect()->back();
      }
    } else {
      return back()->withErrors(['login' => 'Erro no login']);
    }
  }
}
