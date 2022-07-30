@extends('layouts.common')
@section('headers')
@endsection
@section('content')
<!-- Page Heading -->
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Actas de reunión
        </h2>
    </div>
</header>

<!-- Page Content -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
            @if ( $nivel == 3) 

            <button class="btn btn-success" onclick="verForm()" >Nuevo <i class="fa-solid fa-plus"></i></button>
            @endif
            <br>
            <div id="frm_nuevo" style="display:none;">

                <form action="/inicio/actas_de_reunion_guardar" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <!-- <div class="col-lg-1 controlDiv" >
                            <label class="form-label">Folio:</label>
                            <input type="text" class="form-control" id="txtFolio" name="txtFolio" value="">  
                        </div> -->
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Entidad:</label>
                            <input type="text" class="form-control" id="txtEntidad" name="txtEntidad" value=""/>       
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Fecha:</label>
                            <input type="date" class="form-control" id="txtFecha" name="txtFecha" value=""/>
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Lugar:</label>
                            <input type="text" class="form-control" id="txtLugar" name="txtLugar" value=""/>       
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Estado:</label>
                            <select class="form-select" id = "txtEstado" name = "txtEstado">
                                <option value="Completo">Completo</option>
                                <option value="Incompleto">Incompleto</option>
                            </select>
                        </div>
                        <div class="col-lg-3 controlDiv" >
                            <label class="form-label">Archivo:</label>
                            <input type="file" class="form-control" id="txtArchivo" name="file" accept="application/pdf"/>       
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Objetivo:</label>
                        <textarea class="form-control" id="txtObjetivo" name="txtObjetivo" rows="2"></textarea>
                    </div>

                    <input type="hidden" name="acta_id" id="acta_id" value=""/>

                    
                    <input type="submit" class="btn btn-success" style="float:right;" value="Guardar"/>
                    
                </form>
                <button class="btn btn-danger" onclick="ocultarForm()" style="float:right; position:relative; left:-5px;">Cancelar</button> 
                <br/>
            </div>

            

            <h5 class="separtor">Registros</h5>
            <div class="row">
                <div class="col-lg-8">
                </div>

                <div class="col-lg-4 controlDiv" >
                    <label class="form-label">Buscar:</label>
                    <input type="text" class="form-control" id="txtQuickSearch" placeholder="Busca rapida" onkeyup="filtrar()"/>   
                </div>
            </div>
            <br>

            <table class="table tbl-reg table-sm table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Entidad</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Objetivo</th>
                    <th scope="col">Estado</th>
                    <th scope="col"><i class="fa-solid fa-download"></i></th>
                    @if ( $nivel == 3) 
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                    @endif
                    </tr>
                </thead>
                <tbody id="tbl_actas">
                    @foreach ($actas_de_reunion as $acta)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $acta->entidad }}</td>
                        <td>{{ $acta->fecha }}</td>
                        <td>{{ $acta->lugar }}</td>
                        <td>{{ $acta->objetivo }}</td>
                        <td>{{ $acta->estado }}</td>
                        <td><a href="/inicio/actas_de_reunion_view/{{ $acta->id }}"><i style="color: #CCC;font-size:35px;" class="fa-solid fa-file-pdf"></i></a></td>
                        @if ( $nivel == 3) 
                        <td><button class="btn btn-success" onclick="editar({{ $acta->id }})"><i class="fa-solid fa-pen-to-square"></i></button></td>
                        <td><button class="btn btn-success" onclick="eliminar({{ $acta->id }})"><i class="fa-solid fa-xmark"></i></button></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>


            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>

    function verForm()
    {
        limpiarForm();
        $("#frm_nuevo").show(); 
    }
    function ocultarForm()
    {
        $("#frm_nuevo").hide(); 
        limpiarForm();
    }
    function limpiarForm()
    {
        // $("#txtFolio").val(""); 
        $("#txtEntidad").val(""); 
        $("#txtFecha").val(""); 
        $("#txtLugar").val(""); 
        $("#txtEstado").val(""); 
        $("#txtArchivo").val(""); 
        $("#txtObjetivo").val(""); 
        $("#acta_id").val(""); 
    }

    function editar(id)
    {
        limpiarForm();
        $.ajax({url: "/inicio/actas_de_reunion/"+id,context: document.body}).done(function(result) 
        {
            // $("#txtFolio").val(result["folio"]); 
            $("#txtEntidad").val(result["entidad"]); 
            $("#txtFecha").val(result["fecha"].split(" ")[0]); 
            $("#txtLugar").val(result["lugar"]); 
            $("#txtEstado").val(result["estado"]); 
            $("#txtArchivo").val(""); 
            $("#txtObjetivo").val(result["objetivo"]); 
            $("#acta_id").val(result["id"]); 
            $("#frm_nuevo").show(); 
        });
    }

    function eliminar(id)
    {
        if(!confirm("Desea eliminar el registro?" ))
        {
            return;
        }
        $.ajax({url: "/inicio/actas_de_reunion_delete/"+id,context: document.body}).done(function(result) 
        {
            showModal('Notificación','Registro eliminado!');
            window.location.reload();
        });
    }

    function filtrar()
    {
        var value = $("#txtQuickSearch").val().toLowerCase();
        
        $("#tbl_actas tr").filter(function() 
        {
            $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value) > -1 
                )
        });
    }



</script>
@endsection