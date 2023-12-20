<?php

namespace App\Http\Controllers\aluno_controllers\anamnese;

use App\Models\Anamnese;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnamneseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anamnese = Anamnese::select('*')->where('aluno_id', auth()->id())->first();
        if ($anamnese && $anamnese->exists()) {
            $anamnese->cardiaco = json_decode($anamnese->cardiaco);
            $anamnese->alergia = json_decode($anamnese->alergia);
            $anamnese->osseo = json_decode($anamnese->osseo);
        }
        return view('content.aluno_metodos.anamnese.anamnese', compact(['anamnese']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Anamnese::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'cardiaco' => json_encode($request->cardiaco),
                'alergia' => json_encode($request->alergia),
                'osseo' => json_encode($request->osseo),
                'doenca' => $request->doenca,
                'tratamento' => $request->tratamento,
                'medicamento' => $request->medicamento,
                'fumante' => $request->fumante ,
                'diabetico' => $request->diabetico,
                'insulina' => $request->insulina,
                'pressao' => $request->pressao ,
                'nadar' => $request->nadar,
                'aluno_id' => auth()->id(),
            ]
        );

        return redirect()->back()->with('Mensagem', "Anamnese concluida com sucesso, faça seu cadastro em alguma atividade.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anamnese  $anamnese
     * @return \Illuminate\Http\Response
     */
    public function show(Anamnese $anamnese)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anamnese  $anamnese
     * @return \Illuminate\Http\Response
     */
    public function edit(Anamnese $anamnese)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anamnese  $anamnese
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anamnese $anamnese)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anamnese  $anamnese
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anamnese $anamnese)
    {
        //
    }
}
