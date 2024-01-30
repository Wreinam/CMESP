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
        $alunos = User::select('id','name', 'imagem_perfil', 'email', 'cpf',)->where('permissao', 'Aluno')->get();

        return DataTables::of($alunos)
            ->addColumn('action', '_partials/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function showAluno(Request $request)
    {
        $aluno = User::with('user_informacoe', 'user_estuda', 'responsavel_dados', 'user_anamnese')->find($request->id);
        return response()->json($aluno);
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
