<?php

namespace App\Http\Controllers\professor_metodos\chamada;

use App\Models\Chamada;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aula;
use App\Models\Matricula;

class ChamadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turmasDoProfessor = Auth::user()->turmasProfessor()
            ->with('modalidade:id,nome', 'endereco')
            ->where('professor_id', Auth::id())
            ->get();
        return view('content.professor_metodos.chamada.chamada', compact(['turmasDoProfessor']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Http\Response
     */
    public function showAulas(Request $request)
    {
        $aulas = Aula::where('turma_id', $request->id)->get();


        return response()->json($aulas);
    }
    public function showAlunosAula(Request $request)
    {
        $aula = Aula::select('turma_id')->where('id', $request->id)->first();


        if (!$aula) {
            return response()->json(['error' => 'Aula não encontrada'], 404);
        }

        $alunos = Matricula::select('matriculas.id', 'users.name', 'users.id', 'users.imagem_perfil')
            ->join('users', 'matriculas.aluno_id', '=', 'users.id')
            ->where('matriculas.turma_id', $aula->turma_id)
            ->where('status', 'Matriculado')
            ->get();

        return response()->json($alunos);
    }

    public function efetuarChamada(Request $request)
    {
        $dadosPresenca = $request->input('presenca');

        Aula::where('id', $request->aula_id)->update(['Status' => 'Feita']);

        foreach ($dadosPresenca as $id => $presenca) {

            $chamada = new Chamada();
            $chamada->aula_id = $request->aula_id;
            $chamada->aluno_id = $id;
            $chamada->presenca = $presenca;
            $chamada->save();

            if ($presenca === 'Faltou') {
                $turma_id = Aula::where('id', $request->aula_id)->value('turma_id');
                $faltas = Matricula::where('turma_id', $turma_id)->where('aluno_id', $id)->value('faltas');
                Matricula::where('turma_id', $turma_id)->where('aluno_id', $id)->update(['faltas' => $faltas + 1]);
            }
        }

        return redirect()->back();
    }

    public function cancelarChamada(Request $request){
        Aula::where('id', $request->aula_id)->update(['Status' => 'Cancelada', 'justificativa' => $request->justificativa]);
        return redirect()->back();
    }

    public function showAulaCancelada(Request $request){
        $aula = Aula::find($request->id);
        return response()->json($aula);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Http\Response
     */
    public function edit(Chamada $chamada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chamada $chamada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chamada $chamada)
    {
        //
    }
}
