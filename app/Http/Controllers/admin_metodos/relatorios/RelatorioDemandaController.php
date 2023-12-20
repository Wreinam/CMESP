<?php

namespace App\Http\Controllers\admin_metodos\relatorios;

use App\Http\Controllers\Controller;
use App\Models\Modalidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class RelatorioDemandaController extends Controller
{
    public function index()
    {
        

        // $quantidadePorBairroModalidade agora contém os bairros, modalidades e a quantidade de alunos na lista de espera para cada combinação de bairro e modalidade


        return view('content.admin_metodos.relatorios.demanda');
    }
    public function quantidadeDemandaPorBairroModalidade(){
        $quantidadeDemandaPorBairroModalidade = DB::table('lista_espera')
            ->join('users', 'lista_espera.aluno_id', '=', 'users.id')
            ->join('turmas', 'lista_espera.turma_id', '=', 'turmas.id')
            ->join('enderecos', 'turmas.endereco_id', '=', 'enderecos.id')
            ->join('modalidades', 'turmas.modalidade_id', '=', 'modalidades.id')
            ->groupBy('enderecos.bairro', 'modalidades.nome')
            ->select('enderecos.bairro', 'modalidades.nome as modalidade', DB::raw('count(*) as quantidade_alunos_demanda'))
            ->orderBy('enderecos.bairro')
            ->get();

            return Response()->json($quantidadeDemandaPorBairroModalidade);
    }
}
