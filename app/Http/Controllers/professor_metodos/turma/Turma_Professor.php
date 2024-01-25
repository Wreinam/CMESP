<?php

namespace App\Http\Controllers\professor_metodos\turma;

use App\Http\Controllers\Controller;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Matricula;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class Turma_Professor extends Controller
{
    public function listarTurma()
    {
        $turmasDoProfessor = Auth::user()->turmasProfessor()
            ->with('modalidade:id,nome', 'endereco')
            ->where('professor_id', Auth::id())
            ->get();


        return view('content.professor_metodos.turmas.alunos', compact(['turmasDoProfessor']));
    }

    public function showMatriculas(Request $request)
    {
        $turma = Turma::find($request->id);
        $matriculas = $turma->matriculas()->select('name', 'matriculas.*')->where('status', 'Matriculado')->get();
        return response()->json($matriculas);
    }




    public function showAluno(Request $request)
    {
        $aluno = User::with('user_informacoe', 'user_estuda', 'responsavel_dados', 'user_anamnese')->find($request->id);
        return response()->json($aluno);
    }

    public function updateMatricula(Request $request)
    {
        $matricula = Matricula::find($request->id);
        $turma = Turma::find($matricula->turma_id);
        $matricula->update(['status' => 'Desmatriculado']);

        $matriculas = $turma->matriculas()->select('name', 'matriculas.*')->where('status', 'Matriculado')->get();
        return response()->json($matriculas);
    }





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


        return view('content.professor_metodos.aprovar.aprovar', compact(['turmasDoProfessor']));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $turma = Turma::find($request->id);
        $alunos = $turma->users()->select('name')->get();
        return response()->json($alunos);
    }

    public function aprovarAluno(Request $request)
    {
        try {

            $idAluno = $request->idAluno;
            $idTurma = $request->idTurma;

            DB::table('lista_espera')->where('aluno_id', $idAluno)->where('turma_id', $idTurma)->delete();

            Matricula::create([
                'aluno_id' => $idAluno,
                'turma_id' => $idTurma,
            ]);

            $turma = Turma::find($idTurma);
            $alunos = $turma->users()->select('name')->get();

            $nomeAluno = User::find($idAluno)->name;
            $telefone = User::with('user_informacoe')->find($idAluno)->user_informacoe->telefone;
            $modalidade = $turma->modalidade->nome;
            $horario = $turma->horario;

            $numeroLimpo = preg_replace('/[^0-9]/', '', $telefone);

            $sid = 'ACe2d48e8101834e970412bb59c83f22e8';
            $token = '63c20c556e16819c080ce700789df295';
            $twilio_number = '+14422336160';

            // Número de destino
            $to_number = '+55' . $numeroLimpo;  // Substitua pelo número para o qual você deseja enviar o SMS

            // Mensagem a ser enviada
            $message = 'Parabéns ' . $nomeAluno . ' você foi aprovado pela secretaria, compareça na aula de ' . $modalidade . ' no horário: ' . $horario . 'para ter aula';

            // Crie um cliente Twilio
            $twilio = new Client($sid, $token);

            // Envie a mensagem
            $twilio->messages->create(
                $to_number,
                [
                    'from' => $twilio_number,
                    'body' => $message,
                ]
            );





            return response()->json($alunos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
