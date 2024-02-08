<?php

namespace App\Http\Controllers\admin_metodos\cadastrar;

use App\Models\Turma;
use App\Http\Controllers\Controller;
use App\Models\Endereco;
use App\Models\Modalidade;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Aula;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dadosModalidades = Modalidade::all();
        $dadosProfessores = User::select('id', 'name')->where('permissao', 'Professor')->get();
        $dadosEnderecos = Endereco::all();

        return view('content.admin_metodos.cadastrar.turma', compact(['dadosModalidades', 'dadosProfessores', 'dadosEnderecos']));
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
        $turma   =   Turma::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'modalidade_id' => $request->modalidade,
                'professor_id' => $request->professor,
                'endereco_id' => $request->endereco,
                'data_inicio' => $request->data_inicio,
                'data_termino' => $request->data_termino,
                'idade_min_max' => $request->idade_min . " - " . $request->idade_max,
                'horario' => $request->horario_inicio . " ás " . $request->horario_termino,
                'data_termino' => $request->data_termino,
                'dias_semana' => json_encode($request->dia_semana),
                'nivel' => $request->nivel,
                'quantidade_vagas' => $request->quantidade_vagas

            ]
        );
        if (!$request->id) {
            // Supondo que você tenha um array de dias selecionados pelo gestor
            $diasSelecionadosPeloGestor = $request->dia_semana;

            // Mapeie os dias da semana para seus equivalentes ISO 8601
            $mapeamentoDiasSemana = [
                "Domingo" => 7,
                "Segunda-feira" => 1,
                "Terca-feira" => 2,
                "Quarta-feira" => 3,
                "Quinta-feira" => 4,
                "Sexta-feira" => 5,
                "Sabado" => 6,
            ];

            // Crie um array com os números dos dias escolhidos
            $diasEscolhidos = array_map(function ($dia) use ($mapeamentoDiasSemana) {
                return $mapeamentoDiasSemana[$dia];
            }, $diasSelecionadosPeloGestor);

            // Defina o período de aulas desejado
            $dataInicio = $request->data_inicio;
            $dataFim = $request->data_termino;

            // Crie um objeto Carbon para cada data
            $inicio = new Carbon($dataInicio);
            $fim = new Carbon($dataFim);

            // Crie um período entre as duas datas, com passo de um dia
            $diferencaDias = $inicio->diffInDays($fim);

            // Itere sobre o período
            for ($i = 0; $i <= $diferencaDias; $i++) {
                $dataAtual = $inicio->copy()->addDays($i);

                // Verifique se o dia da semana atual está na lista de dias escolhidos
                if (in_array($dataAtual->dayOfWeekIso, $diasEscolhidos)) {
                    // Persista a informação no banco de dados (ajuste conforme sua estrutura)
                    Aula::create([
                        'data' => $dataAtual->toDateString(),
                        'dia_semana' => $dataAtual->dayOfWeekIso,
                        'turma_id' => $turma->id,
                    ]);
                }
            }
        } else {

            $diasSelecionadosPeloGestor = $request->dia_semana;
            // Mapeie os dias da semana para seus equivalentes ISO 8601
            $mapeamentoDiasSemana = [
                "Domingo" => 7,
                "Segunda-feira" => 1,
                "Terca-feira" => 2,
                "Quarta-feira" => 3,
                "Quinta-feira" => 4,
                "Sexta-feira" => 5,
                "Sabado" => 6,
            ];

            // Crie um array com os números dos dias escolhidos
            $diasEscolhidos = array_map(function ($dia) use ($mapeamentoDiasSemana) {
                return $mapeamentoDiasSemana[$dia];
            }, $diasSelecionadosPeloGestor);

            // Defina o período de aulas desejado
            $dataInicio = $request->data_inicio;
            $dataFim = $request->data_termino;

            // Crie um objeto Carbon para cada data
            $inicio = new Carbon($dataInicio);
            $fim = new Carbon($dataFim);

            // Itere sobre o período
            for ($i = 0; $i <= $fim->diffInDays($inicio); $i++) {
                $dataAtual = $inicio->copy()->addDays($i);

                // Verifique se o dia da semana atual está na lista de dias escolhidos
                if (in_array($dataAtual->dayOfWeekIso, $diasEscolhidos)) {
                    // Verifique se já existe um registro para esta data e turma
                    $aulaExistente = Aula::where('data', $dataAtual->toDateString())
                        ->where('turma_id', $turma->id)
                        ->exists();

                    // Se não existir, persista a informação no banco de dados
                    if (!$aulaExistente) {
                        Aula::create([
                            'data' => $dataAtual->toDateString(),
                            'dia_semana' => $dataAtual->dayOfWeekIso,
                            'turma_id' => $turma->id,
                        ]);
                    }
                }
            }
        }
        return Response()->json($turma);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $turmas = Turma::select('turmas.*', 'enderecos.rua', 'enderecos.bairro', 'enderecos.nome_local', 'users.name', 'modalidades.nome')
            ->join('enderecos', 'turmas.endereco_id', '=', 'enderecos.id')
            ->join('users', 'turmas.professor_id', '=', 'users.id')
            ->join('modalidades', 'turmas.modalidade_id', '=', 'modalidades.id')
            ->get();

        return DataTables::of($turmas)
            ->addColumn('action', '_partials/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $turma = Turma::where($where)->first();

        return Response()->json($turma);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Aula::where('turma_id', $request->id)->delete();
        Turma::where('id', $request->id)->delete();
    }
}
