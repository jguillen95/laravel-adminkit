@extends('layouts.plantillabase')

@section('title','Desviación')
@section('h-title','Documentos Dibar')
{{-- @section('card-title','Desviación de proceso') --}}

@section('content')

<form action="{{route('desviacion.update', $desviaciones->id)}}" method="POST" enctype="multipart/form-data" class="row g-3" >
    @csrf
    @method('PUT')
    <div class="col-md-3">
      <label for="area" class="form-label">Área</label>
      <input type="text" class="form-control" id="area" name="area" value="{{$desviaciones->area_des}}">
    </div>
    <div class="col-md-3">
      <label for="producto" class="form-label">Producto</label>
      <input type="text" class="form-control" id="producto" name="producto" value="{{$desviaciones->prodcuto_des}}">
    </div>
    <div class="col-3">
      <label for="presentacion" class="form-label">Presentación</label>
      <input type="text" class="form-control" id="presentacion" name="presentacion" value="{{$desviaciones->presentacion_des}}">
    </div>
    <div class="col-3">
      <label for="lote" class="form-label">Lote</label>
      <input type="text" class="form-control" id="lote" name="lote" value="{{$desviaciones->lote_des}}">
    </div>
    <div class="col-md-3">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="text" class="form-control" id="cantidad" name="cantidad" value="{{$desviaciones->cantidad_des}}">
      </div>
      <div class="col-md-9">
        <label for="descripcion" class="form-label">Descripcion</label>
        <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{$desviaciones->descripcion_des}}">
      </div>
      <div class="col-md-12">
        <label for="desviacion" class="form-label">Desviación</label>
        <input type="text" class="form-control" id="desviacion" name="desviacion" value="{{$desviaciones->desviacion_des}}">
      </div>
      <div class="col-md-12">
        <label for="investigacion" class="form-label">investigacion</label>
        <input type="text" class="form-control" id="investigacion" name="investigacion" value="{{$desviaciones->investigacion_des}}">
      </div>
      <div class="col-md-3">
        <label for="anexos" class="form-label">Anexos</label>
        <input type="text" class="form-control" id="anexos" name="anexos" value="{{$desviaciones->anexos_des}}">
      </div>
      <div class="col-md-3">
        <label for="vobo" class="form-label">Elaborado Por</label>
        <input type="text" class="form-control" id="vobo" name="vobo" value="{{$desviaciones->vobo_des}}">
      </div>
      <div class="col-md-3">
        <label for="departamento" class="form-label">Vobo Calidad</label>
        <input type="text" class="form-control" id="departamento" name="departamento" value="{{$desviaciones->dptoCierre_des}}">
      </div>
      <div class="col-md-3">
        <label for="firma" class="form-label">Vobo Producción</label>
        <input type="text" class="form-control" id="firma" name="firma" value="{{$desviaciones->firma}}">
      </div>
      <div class="col-md-3">
        <label for="fecha_cierre" class="form-label">fecha de Cierre</label>
        <input type="datetime-local" class="form-control" id="fecha_cierre" name="fecha_cierre" value="{{$desviaciones->fechaCierre_des}}">
      </div>
      <div class="col-md-3">
        <label for="estatus" class="form-label">Estatus</label>
        <select type="text" class="form-select" id="estatus" name="estatus" value="{{$desviaciones->Estatus_des}}">
            <option value="1">Abierto</option>
            <option value="2">Pendiente</option>
            <option value="3">Cerrado</option>
        </select>
      </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Actualizar Datos</button>
    </div>
  </form>
@endsection