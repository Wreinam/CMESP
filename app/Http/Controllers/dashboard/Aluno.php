<?php

namespace App\Http\Controllers\dashboard;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\Anamnese;
use App\Models\Modalidade;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Aluno extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $existeAnamnese = Anamnese::where('aluno_id', auth()->id())->exists();
        
        $user = Auth::user();
        $turmasListaEspera = $user->turmas()->with('modalidade:id,nome', 'professor:id,name', 'endereco')->get();

        if($user->matriculas){
            $matriculas = $user->matriculas->with('turma.professor:name,id', 'turma.modalidade:nome,id')->get();
        }else{
            $matriculas = null;
        }


        return view('content.dashboard.aluno.dashboards-aluno', compact(['existeAnamnese', 'turmasListaEspera', 'matriculas']));
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
    public function show($id)
    {
        //
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
