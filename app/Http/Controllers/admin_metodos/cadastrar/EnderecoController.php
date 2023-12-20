<?php

namespace App\Http\Controllers\admin_metodos\cadastrar;

use App\Models\Bairro;
use App\Models\Endereco;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bairros = Bairro::all();
        return view('content.admin_metodos.cadastrar.endereco', compact('bairros'));
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
        Endereco::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'bairro' => $request->bairro,
                'rua' => $request->rua,
                'nome_local' => $request->nome_local,
            ]
        );
    }
    public function storeBairro(Request $request)
    {
        DB::transaction(function () use ($request) {
            $bairro = new Bairro();
            $bairro->nome = $request->nome;
            $bairro->save();
        });

        $bairros = Bairro::all('nome');
        return compact('bairros');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function show(Endereco $endereco)
    {
        $enderecos = Endereco::select();

        return DataTables::of($enderecos)
            ->addColumn('action', '_partials/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array(
            ['id', $request->id],
        );
        $endereco = Endereco::select()->where($where)->first();

        return Response()->json($endereco);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Endereco $endereco)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Endereco::where('id', $request->id)->delete();
    }
}
