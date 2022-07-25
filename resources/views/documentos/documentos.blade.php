@extends('layouts.common')
@section('headers')
@endsection
@section('content')
<!-- Page Heading -->
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Documentos
        </h2>
    </div>
</header>

<!-- Page Content -->
<div class="py-12">
    <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
            @if ($nivel > 1) 
            <button class="btn btn-success" onclick="verForm()" >Nuevo <i class="fa-solid fa-plus"></i></button>
            @endif
            <br>
            <!-- <div id="frm_nuevo" style="display:none;"> -->
            <div id="frm_nuevo" style="display:none;">

                <form action="/documentos/documentos_guardar" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Código:</label>
                            <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" value="">  
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Revisión:</label>
                            <input type="text" class="form-control" id="txtRev" name="txtRev" value="">       
                        </div>
                        <div class="col-lg-5 controlDiv" >
                            <label class="form-label">Titulo:</label>
                            <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" value="">       
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Responsable:</label>
                            <select class="form-select" id = "txtResponsable" name = "txtResponsable" required>
                                <option value=""></option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                            </select>      
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Estado:</label>
                            <select class="form-select" id = "txtEstado" name = "txtEstado">
                                <option value="Completo">Completo</option>
                                <option value="Incompleto">Incompleto</option>
                            </select>
                        </div>

                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Fecha:</label>
                            <input type="date" class="form-control" id="txtFecha" name="txtFecha" value="">
                        </div>

                        <!-- <div class="col-lg-5 controlDiv" >
                            <label class="form-label">Ruta:</label>
                            <select class="form-select" id = "txtRuta" name = "txtRuta" required>
                                <option value=""></option>
                            @if (isset($directorios))
                            @foreach ($directorios as $directorio)
                                <option value="{{ $directorio }}">{{ str_replace('/',' -> ',$directorio) }}</option>
                            @endforeach
                            @endif
                            </select>      
                        </div> -->

                        <div class="col-lg-1 controlDiv" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="chkActivo" id="chkActivo" name="chkActivo">
                                <label class="form-check-label">Activo</label>
                            </div>      
                        </div>
                        
                    </div>
                    <div class="row">

                        <div class="col-lg-4 controlDiv" >
                            <label class="form-label">Archivo Final: <i class="fa-solid fa-file-pdf"></i></label>
                            <input type="file" class="form-control" id="txtArchivo" name="file">       
                        </div>

                        <div class="col-lg-4 controlDiv" >
                            <label class="form-label">Archivo Fuente: <i class="fa-solid fa-file-word"></i> <i class="fa-solid fa-file-excel"></i></label>
                            <input type="file" class="form-control" id="txtArchivoFuente" name="fileSource">       
                        </div>

                        <div class="col-lg-4 controlDiv" >
                            <label class="form-label">Archivo marca de agua:</label>
                            <input type="file" class="form-control" id="txtArchivoMarcaDeAgua" name="fileWM" accept="application/pdf">       
                        </div>

                    </div>



                    <input type="hidden" name="documento_id" id="documento_id" value="">

                    <!-- RUTA DEL ARCHIVO -->
                    <br>

                    <input type="submit" class="btn btn-success" style="float:right;" value="Guardar">
                    
                </form>
                <button class="btn btn-danger" onclick="ocultarForm()" style="float:right; position:relative; left:-5px;">Cancelar</button> 
                <br>
            </div>

            

            <h5 class="separtor">Registros</h5>

            <div class="row">
                <div class="col-lg-4">
                </div>

                <div class="col-lg-2 controlDiv" >
                    <label class="form-label">Estado:</label>
                    <select class="form-select" id = "txtEstadoFiltro" onchange="filtrar()">
                        <option value=""></option>
                        <option value="Completo">Completo</option>
                        <option value="Incompleto">Incompleto</option>
                    </select>
                </div>

                <div class="col-lg-2 controlDiv" >
                    <label class="form-label">Activo:</label>
                    <select class="form-select" id = "txtActivoFiltro" onchange="filtrar()">
                        <option value=""></option>
                        <option value="Activo">Activo</option>
                        <option value="In-activo">In-activo</option>
                    </select>
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
                    <th scope="col">Código</th>
                    <th scope="col" style="max-width:350px">Titulo</th>
                    <th scope="col">Revisión</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Activo</th>
                    @if ($nivel > 1) 
                    <th scope="col">Archivo</th>
                    @endif
                    @if ($nivel > 1) 
                    <th scope="col">Modificable</th>
                    @endif
                    <th scope="col">No-Imprimir</th>
                    @if ($nivel == 3) 
                    <th scope="col">Editar</th>
                    @endif
                    @if ($nivel == 3) 
                    <th scope="col">Eliminar</th>
                    @endif
                    </tr>
                </thead>
                <tbody id="tbl_Documentos">
                    @foreach ($documentos as $documento)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $documento->codigo }}</td>
                        <td style="max-width:300px">{{ $documento->titulo }}</td>
                        <td>{{ $documento->rev }}</td>
                        <td>{{ explode(" ",$documento->fecha)[0] }}</td>
                        <td>{{ $documento->responsable()->name }}</td>
                        <td>{{ $documento->estado }}</td>
                        <td>@if ($documento->activo) <i class="fas fa-check-square" style="color:green"></i> Activo @else <i class="fa-solid fa-square-xmark" style="color:red"></i> In-activo @endif</td>
                        @if ($nivel > 1) 
                            @if ($documento->path())<td><a href="/documentos/documentos_view/{{ $documento->id }}"><i style="color: #CCC;font-size:35px;" class="fa-solid fa-file-pdf"></i></a></td> @else<td></td>@endif
                        @endif
                        @if ($nivel > 1)
                            @if ($documento->path_modificable())<td><a href="/documentos/documentos_view_mod/{{ $documento->id }}"><i style="color: #CCC;font-size:35px;" class="fa-solid fa-file-signature"></i></a></td> @else<td></td>@endif
                        @endif
                        @if ($documento->path_marca_de_agua())<td><a href="/documentos/documentos_view_wmk/{{ $documento->id }}"><i style="color: #CCC;font-size:35px;" class="fa-solid fa-file-circle-exclamation"></i></a></td> @else<td></td>@endif
                        @if ( $nivel == 3) 
                        <td><button class="btn btn-success" onclick="editar({{ $documento->id }})"><i class="fa-solid fa-pen-to-square"></i></button></td>
                        @endif
                        @if ( $nivel == 3) 
                        <td><button class="btn btn-success" onclick="eliminar({{ $documento->id }})"><i class="fa-solid fa-xmark"></i></button></td>
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
        $("#txtCodigo").val(""); 
        $("#txtTitulo").val(""); 
        $("#txtRev").val(""); 
        $("#txtFecha").val(""); 
        $("#txtResponsable").val(""); 
        $("#txtEstado").val(""); 
        $("#chkActivo").prop('checked', false);
        $("#documento_id").val(""); 
    }

    function editar(id)
    {
        limpiarForm();
        $.ajax({url: "/documentos/documentos/"+id,context: document.body}).done(function(result) 
        {
            $("#txtCodigo").val(result["codigo"]); 
            $("#txtTitulo").val(result["titulo"]); 
            $("#txtRev").val(result["rev"]);
            $("#txtFecha").val(result["fecha"].split(" ")[0]); 
            $("#txtResponsable").val(result["responsable_id"]); 
            $("#txtEstado").val(result["estado"]); 
            $("#chkActivo").prop('checked', result["activo"]);
            $("#documento_id").val(result["id"]); 
            $("#frm_nuevo").show();
            $("#txtCodigo").focus(); 
        });
    }

    function eliminar(id)
    {
        if(!confirm("Desea eliminar el documento?" ))
        {
            return;
        }
        $.ajax({url: "/documentos/documentos_delete/"+id,context: document.body}).done(function(result) 
        {
            showModal('Notificación','Documento eliminado!');
            window.location.reload();
        });
    }

    function filtrarEnviadas()
    {
        $("#tbl_Documentos tr").each(function()
            {
                $(this).show();
            });

        if($('#chkActivoFilter').prop('checked'))
        {        

            $("#tbl_Documentos tr").each(function()
            {
                var index = $(this).attr('id').split("_")[2];
                if( $(this).html().includes("In-activo"))
                {
                    $(this).hide();
                }
            });
        }
    }

    function filtrar()
    {
        var value = $("#txtQuickSearch").val().toLowerCase();
        var txtActivoFiltro = $("#txtActivoFiltro").val();
        var txtEstadoFiltro = $("#txtEstadoFiltro").val();
        
        $("#tbl_Documentos tr").filter(function() 
        {
            $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value) > -1 && 
                    ( (txtActivoFiltro == "") ? true : $(this).text().indexOf(txtActivoFiltro) > -1) && 
                    ( (txtEstadoFiltro == "") ? true : $(this).text().indexOf(txtEstadoFiltro) > -1)
                )
        });
    }



</script>
@endsection