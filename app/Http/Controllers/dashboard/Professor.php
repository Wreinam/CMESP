<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Turma;
use Illuminate\Support\Facades\DB;

class Professor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{

    $idUsuario = Auth::id();

    $quantidadeAlunosNaListaEspera = DB::table('lista_espera')
    ->join('turmas', 'lista_espera.turma_id', '=', 'turmas.id')
    ->join('modalidades', 'turmas.modalidade_id', '=', 'modalidades.id')
    ->where('turmas.professor_id', '=', $idUsuario)
    ->select('turmas.horario', 'modalidades.nome', DB::raw('COUNT(*) as quantidade_alunos_lista_espera'))
    ->groupBy('turmas.horario', 'modalidades.nome')
    ->get();

        return view('content.dashboard.professor.dashboards-professor', compact('quantidadeAlunosNaListaEspera'));
    }

}
