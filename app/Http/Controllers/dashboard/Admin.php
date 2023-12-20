<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Admin extends Controller
{
  public function index()
  {
    $totalMatriculas = Matricula::where('status', 'Matriculado')->count();
    $demanda = DB::table('lista_espera')->count();
    $totalUsuarios = User::where('permissao', 'Aluno')->count();
    $totalIdosos = User::with('user_informacoe')->whereHas('user_informacoe', function ($query) {
      $query->where('idade', '>=', 60);
    })->count();
    $totalCriancas = User::where('permissao', 'Aluno')->with('user_informacoe')->whereHas('user_informacoe', function ($query) {
      $query->where('idade', '<=', 14);
    })->count();
    return view('content.dashboard.admin.dashboards-admin', compact([
      'totalMatriculas',
      'demanda',
      'totalUsuarios',
      'totalIdosos',
      'totalCriancas'
    ]));
  }
}
