<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\ficha;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Suplemento;
use App\Models\Informacion;

class FichaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fichas=Ficha::all();
        return view('fichas.index', compact('fichas'));
       
    }
    public function buscar(Request $request)
    {
        $input = $request->all();

        if($request->get('buscar')){
            $noticias = ficha::where("producto", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("lote", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("id_sap", "LIKE", "%{$request->get('buscar')}%")
                ->paginate(10);
        return view('fichas.index')->with('buscar', $noticias);
        }else{
        $noticias = ficha::paginate(5);
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
        return view('fichas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $suplemento=$request->input('check');
        $user=auth()->user()->firma;
        $fichas=new Ficha;
        $fichas->producto=$request->input('producto');
        $fichas->lote=$request->input('lote');
        $fichas->fecha=$request->input('fecha_cad');
        $fichas->contenido=$request->input('contenido');
        $fichas->id_sap=$request->input('id_sap');
        $fichas->descripcion=$request->input('descripcion');
        $fichas->caracteristicas=$request->input('caracteristicas');
        $fichas->porcion=$request->input('porcion');
        // if($suplemento==1){
        //         $fichas->ingredientes=$request->input('ingredientes');
        //         $fichas->info_nutri=$request->input('info_nutri');
        //                     }else{
        //                         $fichas->ingredientes='No aplica';
        //                         $fichas->info_nutri='No aplica';
        //                     }
        if($suplemento==1){
        $fichas->ingredientes=$suplemento;
        }else{
            $fichas->ingredientes="CANCELADO"; 
        }
        $fichas->info_nutri='CANCELADO';
        // $fichas->presentacion_img=$request->input('presentacion_img');
        $fichas->uso=$request->input('uso');
        $fichas->almacen=$request->input('almacen');
        $fichas->advertencias=$request->input('advertencias');
        $fichas->elaboro=$user;
        if($request->hasFile("presentacion_img")){

            $imagen = $request->file("presentacion_img");                        
            $nombreimagen = $imagen->getClientOriginalName();
            $ruta = public_path("img/fichas/");            
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $fichas->presentacion_img = $nombreimagen;
        }
       $fichas->save();
       if($suplemento==1){
       return view ('fichas.informacion');
     }else{
        return view ('fichas.suplemento');
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
                $iden= $id;
                $fichas=Ficha::where('id', $iden)->get();
                $check=Ficha::select('ingredientes')
                ->where('id', $iden)->get();
                $suplemento=Suplemento::where('ficha_id', $iden)->get();
                $informacion=Informacion::where('ficha_id', $iden)->get();
                // $informacion=Informacion::where('ficha_id', 5)->get();
                $pdf= Pdf::loadView('fichas.pdf', compact('fichas','check','suplemento','informacion'));
                return $pdf->stream('fichas.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function edit(ficha $ficha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ficha $ficha)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function destroy(ficha $ficha)
    {
        //
    }
}
