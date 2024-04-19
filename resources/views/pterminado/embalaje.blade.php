@extends('layouts.plantillabase')

@section('title','PT:Embalaje')
@section('h-title','Documentos Dibar')

@section('content')
{{-- Indicaciones --}}

<form action="{{route('embalaje.store')}}" method="POST" enctype="multipart/form-data" class="row g-3" >
    @csrf
    <h3 class="text-center pad-basic no-btm">Material de Embalaje</h3>
    <table class="table table-hover"  id="tabla">
            <tr class="fila-fija">
              <td scope="col">
                <label for="material" class="form-label">MATERIAL</label>
                <input type="text" class="form-control" id="material" name="material[]" required>
              </td>
                <td scope="col">
                  <label for="codigo_emb" class="form-label">CODIGO</label>
                  <input type="text" class="form-control" id="codigo_emb" name="codigo_emb[]" required>
                </td>
                <td scope="col">
                  <label for="descripcion" class="form-label">DESCRIPCIÓN</label>
                  <input type="text" class="form-control" id="descripcion" name="descripcion[]" required>
                  </td>
                <td class="eliminar"><input type="button"   value="-"/></td>
            </tr>
    </table>

    <div class="btn-der">
        <input id="adicional" name="adicional" type="button" class="btn btn-success" value="+ Agregar otro Item"> </input>
        <input type="submit" name="insertar" value="Insertar Datos" class="btn btn-info"/>
    </div>
</form>
   
     

     <script>
			
        $(function(){
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#adicional").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla");
            });
         
            // Evento que selecciona la fila y la elimina 
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
        });
    </script>
@endsection
