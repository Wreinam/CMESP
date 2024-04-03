<?php

namespace App\Http\Controllers\admin_metodos\lista_espera;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turma;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ListaEsperaController extends Controller
{
    public function index()
    {
        return view('content.admin_metodos.lista-espera.lista-espera');
    }

    public function showTurmasListaEspera(Request $request)
    {
        $turmas = Turma::select([
            'turmas.id AS id',
            'users.name AS professor_nome',
            'modalidades.nome AS modalidade',
            'turmas.horario AS horario',
            'turmas.idade_min_max AS idade',
            'turmas.quantidade_vagas AS quantidade_vagas',
            DB::raw('(SELECT COUNT(*) FROM lista_espera WHERE turmas.id = lista_espera.turma_id) AS quantidade_alunos')
        ])
            ->leftJoin('users', 'turmas.professor_id', '=', 'users.id')
            ->leftJoin('modalidades', 'turmas.modalidade_id', '=', 'modalidades.id')
            ->get();

            return DataTables::of($turmas)
            ->addColumn('action', '_partials/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);

    }

    public function showListaEspera(Request $request)
    {
        $turma = Turma::find($request->id);
        $usuarios_na_lista_de_espera = $turma->users()->get();
        return response()->json($usuarios_na_lista_de_espera);
    }
}
