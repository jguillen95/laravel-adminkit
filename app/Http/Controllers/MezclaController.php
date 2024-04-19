<?php

namespace App\Http\Controllers;

use App\Models\Mezcla;
use App\Models\MezclaItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Dompdf;
use Dompdf\Options;

class MezclaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mezcla=Mezcla::all();
        return view('mezcla.index', compact('mezcla'));
    }
    public function buscar(Request $request)
    {
        $input = $request->all();

        if($request->get('buscar')){
            $noticias = Mezcla::where("id", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("producto", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("reviso", "LIKE", "%{$request->get('buscar')}%")
                ->paginate(10);
        return view('mezcla.index')->with('buscar', $noticias);
        }else{
        $noticias = Mezcla::paginate(5);
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
        return view('mezcla.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mezcla=new Mezcla;
        $mezcla->producto=$request->input('producto');
        $mezcla->lote=$request->input('lote');
        $mezcla->q1=$request->input('q1');
        $mezcla->q3=$request->input('q3');
        $mezcla->q4=$request->input('q4');
        $mezcla->reviso=$request->input('reviso');
        $mezcla->autorizo=$request->input('autorizo');
        $mezcla->observaciones=$request->input('observaciones');
        $mezcla->save();
       return redirect('mezclaItem/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $iden= $id;
                $mezcla=Mezcla::where('id', $iden)->get();
                $mezclaItem=MezclaItem::where('mezcla_id',$iden)->get();
                $pdf= Pdf::loadView('mezcla.pdf', compact('mezcla','mezclaItem'))->setPaper('a4', 'portrait');
                return $pdf->stream('mezcla.pdf');
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function edit(Mezcla $mezcla)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mezcla $mezcla)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mezcla  $mezcla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mezcla $mezcla)
    {
        //
    }
}
