<?php

namespace App\Http\Controllers\aluno_controllers\turma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Turma;
use App\Models\Anamnese;
use App\Models\Bairro;
use App\Models\Matricula;
use App\Models\Modalidade;

class Turma_AlunoController extends Controller
{
    public function index()
    {
        $existeAnamnese = Anamnese::where('aluno_id', auth()->id())->exists();
        $turmas = Turma::paginate(6);

        $modalidades = Modalidade::orderBy('nome')->get();
        $bairros = Bairro::orderBy('nome')->get();
        $professores = User::where('permissao', 'Professor')->orderBy('name')->get(['id', 'name']);




        foreach ($turmas as $turma) {
            $turma->dias_semana = implode(' , ', json_decode($turma->dias_semana));
            $turma->modalidade = $turma->modalidade->nome;
            $turma->professor = $turma->professor->name;
            $turma->endereco = $turma->endereco;
        }
        return view('content.aluno_metodos.cadastro_turma.cadastro_turma', compact(['turmas', 'existeAnamnese', 'modalidades', 'bairros', 'professores']));
    }

    public function filtrarTurma(Request $request)
    {
        $turmasFiltradas = Turma::where(function ($query) use ($request) {
            
            // Verifica se a modalidade foi escolhida
            if ($request->modalidade && $request->modalidade != 'todos') {
                $query->where('modalidade_id', $request->modalidade);
            }
    
            // Verifica se o bairro foi escolhido
            if ($request->bairro && $request->bairro != 'todos') {
                $query->whereHas('endereco', function ($innerQuery) use ($request) {
                    $innerQuery->where('bairro', $request->bairro);
                });
            }
    
            // Verifica se o professor foi escolhido
            if ($request->professor && $request->professor != 'todos') {
                $query->where('professor_id', $request->professor);
            }
        })
        ->get();
    

        foreach ($turmasFiltradas as $turma) {
            $turma->dias_semana = implode(' , ', json_decode($turma->dias_semana));
            $turma->modalidade = $turma->modalidade->nome;
            $turma->professor = $turma->professor->name;
            $turma->endereco = $turma->endereco;
        }

        return response()->json(['turmaFiltrada' => $turmasFiltradas]);
    }

    public function storeListaEspera(Request $request)
    {
        $user = Auth::user();
        $turmaId = $request->id;

        // Verificar se o usuário já está inscrito na turma
        $jaInscrito = $user->turmas()->where('turma_id', $turmaId)->exists();
        $jaMatriculado = Matricula::where('aluno_id', $user->id)->where('turma_id', $turmaId)->where('status', 'Matriculado')->get();

        if (!$jaInscrito && $jaMatriculado->isEmpty()) {
            // Se não estiver inscrito, inscrever na turma
            $user->turmas()->attach($turmaId);
            return response()->json(['mensagem' => 'Inscrição na turma realizada com sucesso']);
        } else {
            return response()->json(['mensagem' => 'Usuário já está inscrito nesta turma']);
        }
    }
}
