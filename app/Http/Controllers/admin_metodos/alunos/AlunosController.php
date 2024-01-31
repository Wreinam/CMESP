<?php

namespace App\Http\Controllers\admin_metodos\alunos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlunosController extends Controller
{
    public function index()
    {
        return view('content.admin_metodos.alunos.alunos');
    }
    public function show(User $alunos)
    {
        $alunos = User::select('users.id', 'users.name', 'users.imagem_perfil', 'users.email', 'users.cpf')
            ->where('users.permissao', 'Aluno')
            ->selectRaw('(SELECT COALESCE(COUNT(aluno_id), 0) FROM matriculas WHERE matriculas.aluno_id = users.id AND matriculas.status = "Matriculado") as matriculas_quantidade')
            ->selectRaw('(SELECT COALESCE(COUNT(aluno_id), 0) FROM lista_espera WHERE lista_espera.aluno_id = users.id) as lista_espera_quantidade')
            ->get();


        return DataTables::of($alunos)
            ->addColumn('action', '_partials/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function showAluno(Request $request)
    {
        $aluno = User::with('user_informacoe', 'user_estuda', 'responsavel_dados', 'user_anamnese')->find($request->id);
        $matriculas = $aluno->matriculas()
            ->where('status', 'Matriculado')
            ->with(['turma' => function ($query) {
                $query->with('modalidade:id,nome', 'professor:id,name', 'endereco');
            }])
            ->get();

        $listaEspera = $aluno->turmas()
            ->with('modalidade:id,nome', 'professor:id,name', 'endereco')
            ->get();


        $responseData = [
            'aluno' => $aluno,
            'matriculas' => $matriculas,
            'listaEspera' => $listaEspera,
        ];

        return response()->json($responseData);
    }

    public function resetarSenha(Request $request)
    {
        // Obter a data de nascimento do usuário
        $user = User::with('user_informacoe')->find($request->id);

        if ($user) {
            $dataNascimento = $user->user_informacoe->dataNascimento;

            // Remover hífens e formatar a data de nascimento no formato desejado (15032017)
            $numerosDataNascimento = implode("", array_reverse(explode('-', $dataNascimento)));

            // Atualizar a senha do usuário com a nova senha baseada na data de nascimento formatada
            User::where('id', $request->id)->update(['password' => Hash::make($numerosDataNascimento)]);

            return response()->json(['mensagem' => 'Senha resetada com sucesso'], 200);
        } else {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
    }
}
