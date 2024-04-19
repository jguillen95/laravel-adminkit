<?php

namespace App\Http\Controllers;

use App\Models\Desviaciones;
use App\Models\Corecciones;
use Illuminate\Http\Request;
use App\Models\ModDocumentos;
use App\Models\Responsable;
use App\Models\Seguimiento;
use App\Models\Responsables;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;

class DesviacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $desviaciones=Desviaciones::all();
        return view('desviacion.index', compact('desviaciones'));
    }
    public function buscar(Request $request)
    {
        $input = $request->all();

        if($request->get('buscar')){
            $noticias = Desviaciones::where("idComp", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("prodcuto_des", "LIKE", "%{$request->get('buscar')}%")
                ->OrWhere("lote_des", "LIKE", "%{$request->get('buscar')}%")
                ->paginate(10);
        return view('desviacion.index')->with('buscar', $noticias);
        }else{
        $noticias = Desviaciones::paginate(5);
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
        
        $responsablesC=Responsable::All()
                    ->where('dpto_resp','Calidad');
        $responsablesP=Responsable::All()->where('dpto_resp','Producción');
        return view('desviacion.create', compact('responsablesC','responsablesP'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $firma=auth()->user()->firma;
       $nombre=auth()->user()->name;
       $ejercicio=date("Y");
       $consulta=Desviaciones::latest('idComp')->first()->idComp;
       $ultimos=Str::substr($consulta,4);
       $auto=$ultimos + 1;
       $dato=Str::substr($consulta, 0,4);
       
       if($dato==$ejercicio){
            $idComp=$ejercicio."-".$auto;
       }else{
            $idComp=$ejercicio."-"."1";
            }
       $compuesto=$nombre.', '.$request->input('vobo');
       $desviaciones=new Desviaciones;
       $desviaciones->area_des=$request->input('area');
       $desviaciones->prodcuto_des=$request->input('producto');
       $desviaciones->presentacion_des=$request->input('presentacion');
       $desviaciones->lote_des=$request->input('lote');
       $desviaciones->cantidad_des=$request->input('cantidad');
       $desviaciones->descripcion_des=$request->input('descripcion');
       $desviaciones->desviacion_des=$request->input('desviacion');
       $desviaciones->investigacion_des=$request->input('investigacion');
    //    $desviaciones->anexos_des=$request->input('anexos');
       $desviaciones->vobo_des=$compuesto;
       $desviaciones->dptoCierre_des=$request->input('departamento');
       $desviaciones->firma=$firma;
       $desviaciones->responsableC=$request->input('responsableC');
       $desviaciones->responsableP=$request->input('responsableP');
       $desviaciones->fechaCierre_des=$request->input('fecha_cierre');
       $desviaciones->Estatus=$request->input('estatus');
       $desviaciones->firma_cierre=$request->input('firma_cierre');
       $desviaciones->idComp=$idComp;
       if($request->hasFile("anexos")){

        $imagen = $request->file("anexos");                        
        $nombreimagen = $imagen->getClientOriginalName();
        $ruta = public_path("img/post/");            
        copy($imagen->getRealPath(),$ruta.$nombreimagen);
        $desviaciones->anexos_des = $nombreimagen;
        
                                    }
       $desviaciones->save();
       return redirect('correccion/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Desviaciones  $desviaciones
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
            $iden= $id;
            $almacena = Desviaciones::select('desviaciones.id','desviaciones.area_des',
                        'desviaciones.prodcuto_des','desviaciones.presentacion_des',
                        'desviaciones.lote_des','desviaciones.cantidad_des',
                        'desviaciones.descripcion_des','desviaciones.desviacion_des',
                        'desviaciones.investigacion_des','desviaciones.anexos_des',
                        'desviaciones.vobo_des', 'desviaciones.dptoCierre_des',
                        'desviaciones.firma','desviaciones.fechaCierre_des','desviaciones.Estatus',
                        'desviaciones.responsableC', 'desviaciones.responsableP','desviaciones.firma_cierre', 'desviaciones.idComp')
                 ->where('desviaciones.id', $iden)
                 ->get();
                 
            $almacenados=Corecciones::select('corecciones.id','corecciones.actividad','corecciones.responsable','corecciones.fecha_corre','corecciones.firma_corre')
            ->where('desviacionCorrecion_id',$iden)
            ->where('tipo','Corrección')
            ->get();
            $almacenadosC=Corecciones::select('corecciones.id','corecciones.actividad','corecciones.responsable','corecciones.fecha_corre','corecciones.firma_corre')
            ->where('desviacionCorrecion_id',$iden)
            ->where('tipo','Acción')
            ->get();

            $almacenDocs=ModDocumentos::select('mod_documentos.id','mod_documentos.codigo','mod_documentos.titulo','mod_documentos.responsable', 'mod_documentos.fecha', 'mod_documentos.firma_mod')
            ->where('desviacionDoc_id', $iden)
            ->get();
            $almacenSeguimientos=Seguimiento::select('seguimientos.id','seguimientos.descripcion_seg', 'seguimientos.realizo_seg', 'seguimientos.fecha_seg')
            ->where('desviacion_id', $iden)
            ->get();
                $pdf= Pdf::loadView('desviacion.pdf', compact('almacena', 'almacenados','almacenDocs', 'almacenSeguimientos', 'iden', 'almacenadosC'));
                return $pdf->stream('Desviacion.pdf');
          
                // return view('desviacion.pdf', compact('almacena'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Desviaciones  $desviaciones
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $desviaciones=Desviaciones::find($id);
        return view('desviacion.update',compact('desviaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Desviaciones  $desviaciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $desviaciones= Desviaciones::find($id);
       $desviaciones->area_des=$request->input('area');
       $desviaciones->prodcuto_des=$request->input('producto');
       $desviaciones->presentacion_des=$request->input('presentacion');
       $desviaciones->lote_des=$request->input('lote');
       $desviaciones->cantidad_des=$request->input('cantidad');
       $desviaciones->descripcion_des=$request->input('descripcion');
       $desviaciones->desviacion_des=$request->input('desviacion');
       $desviaciones->investigacion_des=$request->input('investigacion');
       $desviaciones->anexos_des=$request->input('anexos');
       $desviaciones->vobo_des=$request->input('vobo');
       $desviaciones->dptoCierre_des=$request->input('departamento');
       $desviaciones->firma=$request->input('firma');
       $desviaciones->fechaCierre_des=$request->input('fecha_cierre');
       $desviaciones->Estatus=$request->input('estatus');
       $desviaciones->update();
       return redirect('desviacion'); 
    }
    public function guardar(Request $request){
        $post = new Desviaciones();

        // Tratamiento de la imagen
        if($request->hasFile("imagen")){

            $imagen = $request->file("anexos");                        
            $nombreimagen = $imagen->getClientOriginalName();
            $ruta = public_path("img/post/");            
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $post->imagen = $nombreimagen;
            
        }

        $post->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Desviaciones  $desviaciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desviaciones $desviaciones)
    {
        //
    }
  
}
