@extends('layouts.plantillabase')

@section('title','Reponsables')
@section('h-title','Documentos Dibar')
{{-- @section('card-title','Desviación de proceso') --}}

@section('content')


<form action="{{route('responsable.update', $responsables->id)}}" method="POST" enctype="multipart/form-data" class="row g-3" >
    @csrf
    @method('PUT')
    <div class="col-md-6">
      <label for="contrasena" class="form-label">Nueva contraseña</label>
      <input type="text" class="form-control" id="contrasena" name="contrasena">
    </div>
    {{-- <div class="col-md-6">
      <label for="puesto" class="form-label">Puesto</label>
      <input type="text" class="form-control" id="puesto" name="puesto" value="{{$responsables->puesto_resp}}">
    </div>
    <div class="col-6">
      <label for="departamento" class="form-label">Departamento</label>
      <input type="text" class="form-control" id="departamento" name="departamento" placeholder="list" value="{{$responsables->dpto_resp}}">
    </div> --}}
    <div class="col-12">
      <button type="submit" class="btn btn-info"  style="color:rgb(255, 255, 255); background-color:green; text-align:center; line-height:0px;" >Actualizar</button>
    </div>
  </form>

@endsection