<?php

namespace App\Http\Controllers;

use App\Models\Contenido;
use App\Models\Logistica;
use App\Models\pterminado;
use App\Models\Embalaje;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Dompdf;
use PhpParser\Node\Stmt\Return_;

class PterminadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pterminado.index');
    }
    public function buscar(Request $request)
    {
        $input = $request->all();

        if($request->get('buscar')){
            $noticias = pterminado::where("descripcion", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("id_sap", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("marca", "LIKE", "%{$request->get('buscar')}%")
                ->paginate(10);
        return view('pterminado.index')->with('buscar', $noticias);
        }else{
        $noticias = pterminado::paginate(5);
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
        return view('pterminado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pterminado=new pterminado();
        $pterminado->descripcion=$request->input('descripcion');
        $pterminado->id_sap=$request->input('id_sap');
        $pterminado->codigo=$request->input('codigo');
        $pterminado->categoria=$request->input('categoria');
        $pterminado->sub_categoria=$request->input('sub_categoria');
        $pterminado->marca=$request->input('marca');
        // Imagenes
        if($request->hasFile("img_envase")){

            $imagen = $request->file("img_envase");                        
            $nombreimagen = $imagen->getClientOriginalName();
            $ruta = public_path("img/pt/");            
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $pterminado->img_envase = $nombreimagen;
        }
        if($request->hasFile("img_display")){

            $imagen = $request->file("img_display");                        
            $nombreimagen = $imagen->getClientOriginalName();
            $ruta = public_path("img/pt/");            
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $pterminado->img_display = $nombreimagen;
        }
        if($request->hasFile("img_caja")){

            $imagen = $request->file("img_caja");                        
            $nombreimagen = $imagen->getClientOriginalName();
            $ruta = public_path("img/pt/");            
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $pterminado->img_caja = $nombreimagen;
        }
        if($request->hasFile("img_palet")){

            $imagen = $request->file("img_palet");                        
            $nombreimagen = $imagen->getClientOriginalName();
            $ruta = public_path("img/pt/");            
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $pterminado->img_palet = $nombreimagen;
        }
        if($request->hasFile("img_opc")){

            $imagen = $request->file("img_opc");                        
            $nombreimagen = $imagen->getClientOriginalName();
            $ruta = public_path("img/pt/");            
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $pterminado->img_opc = $nombreimagen;
        }
        // Imagenes fin
        $pterminado->color_granel=$request->input('color_granel');
        $pterminado->olor_granel=$request->input('olor_granel');
        $pterminado->apariencia_granel=$request->input('apariencia_granel');
        $pterminado->almacenamiento=$request->input('almacenamiento');
        $pterminado->transporte=$request->input('transporte');
        $pterminado->lote_caducidad=$request->input('lote_caducidad');
        $pterminado->save();
       return view('pterminado.logistica');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pterminado  $pterminado
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $iden= $id;
        $pterminado=pterminado::where('id',$iden )->get();
        $logistica=Logistica::where('pterminado_id',$iden )->get();
        $contenido=Contenido::where('pterminado_id',$iden )->get();
        $embalaje=Embalaje::where('pterminado_id',$iden )->get();
        $pdf= Pdf::loadView('pterminado.pdf', compact('pterminado','logistica','contenido','embalaje'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('pterminado.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pterminado  $pterminado
     * @return \Illuminate\Http\Response
     */
    public function edit(pterminado $pterminado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pterminado  $pterminado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pterminado $pterminado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pterminado  $pterminado
     * @return \Illuminate\Http\Response
     */
    public function destroy(pterminado $pterminado)
    {
        //
    }
}
