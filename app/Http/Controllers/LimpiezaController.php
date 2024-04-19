<?php

namespace App\Http\Controllers;

use App\Models\Limpieza;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Dompdf;
use Dompdf\Options;

class LimpiezaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limpieza=Limpieza::all();
        return view('limpieza.index', compact('limpieza'));
    }

    public function buscar(Request $request)
    {
        $input = $request->all();

        if($request->get('buscar')){
            $noticias = Limpieza::where("id", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("producto", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("lote", "LIKE", "%{$request->get('buscar')}%")
                ->paginate(10);
        return view('limpieza.index')->with('buscar', $noticias);
        }else{
        $noticias = Limpieza::paginate(5);
            }

        return response($noticias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('limpieza.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $limpieza=new Limpieza;
        $limpieza->fecha=$request->input('fecha');
        $limpieza->linea=$request->input('linea');
        $limpieza->lote=$request->input('lote');
        $limpieza->orden=$request->input('orden');
        $limpieza->producto=$request->input('producto');
        $limpieza->presentacion=$request->input('presentacion');
        $limpieza->verifico=$request->input('verifico');
        $limpieza->q1=$request->input('q1');
        $limpieza->q2=$request->input('q2');
        $limpieza->q3=$request->input('q3');
        $limpieza->q4=$request->input('q4');
        $limpieza->q5=$request->input('q5');
        $limpieza->q6=$request->input('q6');
        $limpieza->q7=$request->input('q7');
        $limpieza->q8=$request->input('q8');
        $limpieza->q9=$request->input('q9');
        $limpieza->q10=$request->input('q10');
        $limpieza->nota=$request->input('nota');
       $limpieza->save();
       return redirect('limpieza');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Limpieza  $limpieza
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $iden= $id;
             $limpieza=Limpieza::where('id', $iden)
            ->get();
                $pdf= Pdf::loadView('limpieza.pdf', compact('limpieza'));
                return $pdf->stream('limpieza.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Limpieza  $limpieza
     * @return \Illuminate\Http\Response
     */
    public function edit(Limpieza $limpieza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Limpieza  $limpieza
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Limpieza $limpieza)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Limpieza  $limpieza
     * @return \Illuminate\Http\Response
     */
    public function destroy(Limpieza $limpieza)
    {
        //
    }
}
