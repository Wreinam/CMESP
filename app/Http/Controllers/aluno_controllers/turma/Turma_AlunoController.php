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

        $modalidades = Modalidade::all();
        $bairros = Bairro::all('*');

        foreach ($turmas as $turma) {
            $turma->dias_semana = implode(' , ', json_decode($turma->dias_semana));
            $turma->modalidade = $turma->modalidade->nome;
            $turma->professor = $turma->professor->name;
            $turma->endereco = $turma->endereco;
        }
        return view('content.aluno_metodos.cadastro_turma.cadastro_turma', compact(['turmas', 'existeAnamnese', 'modalidades', 'bairros']));
    }

    public function filtrarTurma(Request $request)
    {
        $turmasFiltrada = Turma::where('modalidade_id', $request->modalidade)
            ->whereHas('endereco', function ($query) use ($request) {
                $query->where('bairro', $request->bairro);
            })
            ->get();

        foreach ($turmasFiltrada as $turma) {
            $turma->dias_semana = implode(' , ', json_decode($turma->dias_semana));
            $turma->modalidade = $turma->modalidade->nome;
            $turma->professor = $turma->professor->name;
            $turma->endereco = $turma->endereco;
        }

        return response()->json(['turmaFiltrada' => $turmasFiltrada]);
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
