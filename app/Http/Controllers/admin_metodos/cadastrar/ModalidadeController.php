<?php

namespace App\Http\Controllers\admin_metodos\cadastrar;

use App\Models\Modalidade;
use App\Http\Controllers\Controller;
use App\Http\Controllers\user_interface\Modals;
use Illuminate\Auth\Recaller;
use Illuminate\Http\Request;
use LDAP\Result;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;

class ModalidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.admin_metodos.cadastrar.modalidade');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
  
        $modalidade   =   Modalidade::updateOrCreate(
                    [
                     'id' => $request->id,
                    ],
                    [
                    'nome' => $request->nome, 
                    
                    ]);    
                          
        return Response()->json($modalidade);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modalidade  $modalidade
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $modalidades = Modalidade::select();
        return DataTables::of($modalidades)
        ->addColumn('action', '_partials/action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modalidade  $modalidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $modalidade = Modalidade::where($where)->first();

        return Response()->json($modalidade);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modalidade  $modalidade
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modalidade  $modalidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Modalidade::where('id',$request->id)->delete();
       
    }
}
