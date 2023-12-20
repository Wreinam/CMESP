<?php

namespace App\Http\Controllers\admin_metodos\cadastrar;

use App\Models\User; //Estou puxado o model user pois o mesmo usuario de professor é de aluno e admin
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.admin_metodos.cadastrar.professor');
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
        $cpf = "";
        if (!$request->cpf) {
            $cpf = Hash::make(Carbon::now());
        } else {
            $cpf = $request->cpf;
        }

        if (!$request->id) {
            User::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'name' => $request->nome,
                    'email' => $request->email,
                    'cpf' => $cpf,
                    'password' => Hash::make($request->senha),
                    'permissao' => "Professor",

                ]
            );
        } else {
            User::where('id', $request->id)->update([
                'name' => $request->nome,
                'email' => $request->email
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $professor
     * @return \Illuminate\Http\Response
     */
    public function show(User $professor)
    {
        $professores = User::select()
            ->where('permissao', 'Professor') // Condição para encontrar professores
            ->orderBy('created_at', 'desc') // Ordena por data de criação
            ->get();
        return DataTables::of($professores)
            ->addColumn('action', '_partials/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array(
            ['id', $request->id],
            ['permissao', 'Professor']
        );
        $professor = User::select('id','name', 'email')->where($where)->first();

        return Response()->json($professor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $professor)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where('id',$request->id)->delete();
    }
}
