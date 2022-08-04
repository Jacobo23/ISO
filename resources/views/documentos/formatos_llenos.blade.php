@extends('layouts.common')
@section('headers')
@endsection
@section('content')
<!-- Page Heading -->
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Formatos llenos
        </h2>
    </div>
</header>

<!-- Page Content -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

             @if ( $nivel > 1) 

            <button class="btn btn-success" onclick="verForm()" >Nuevo <i class="fa-solid fa-plus"></i></button>
            <br>
            @endif
            <div id="frm_nuevo" style="display:none;">

                <form action="/documentos/formatos_llenos_guardar" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <!-- <div class="col-lg-1 controlDiv" >
                            <label class="form-label">Folio:</label>
                            <input type="text" class="form-control" id="txtFolio" name="txtFolio" value="">  
                        </div> -->



                        <div class="col-lg-3 controlDiv" >
                            <label class="form-label">Código:</label>
                            <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" value="">       
                        </div>
                        <div class="col-lg-7 controlDiv" >
                            <label class="form-label">Titulo:</label>
                            <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" value="">       
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Fecha:</label>
                            <input type="date" class="form-control" id="txtFecha" name="txtFecha" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 controlDiv" >
                            <label class="form-label">Archivo:</label>
                            <input type="file" class="form-control" id="txtArchivo" name="file" accept="application/pdf">       
                        </div>
                        <div class="col-lg-6 controlDiv" >
                            <label class="form-label">Adjuntos:</label>
                            <input type="file" class="form-control" id="txtEvidencias" name="evidencias[]" multiple>       
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción:</label>
                        <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" maxlenght="100"></textarea>
                    </div>

                    <div class="row">

                    <div class="col-lg-4 controlDiv" >
                            <label class="form-label">Responsabilidades:</label>
                            <select class="form-select" id = "txtResponsabilidad" name = "txtResponsabilidad">
                                <option value=""></option>
                            @foreach ($responsabilidades as $responsabilidad)
                                <option value="{{ $responsabilidad->id }}">{{ $responsabilidad->id }} | {{ $responsabilidad->tarea }} | {{ explode(" ",$responsabilidad->fecha_de_expiracion)[0] }}</option>
                            @endforeach
                            </select>      
                        </div>

                    </div>

                    <input type="hidden" name="formato_lleno_id" id="formato_lleno_id" value="">

                    
                    <input type="submit" class="btn btn-success" style="float:right;" value="Guardar">
                    
                </form>
                <button class="btn btn-danger" onclick="ocultarForm()" style="float:right; position:relative; left:-5px;">Cancelar</button> 
                <br>
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
                    <th scope="col">Código</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Fecha</th>
                    <th scope="col"><i class="fa-solid fa-download"></i></th>
                    <th scope="col"><i class="fa-solid fa-download"></i></th>
                    @if ( $nivel > 1) 
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                    @endif
                    </tr>
                </thead>
                <tbody id="tbl_formatos">
                    @foreach ($formatos_llenos as $formato)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $formato->codigo }}</td>
                        <td>{{ $formato->titulo }}</td>
                        <td>{{ $formato->descripcion }}</td>
                        <td>{{ $formato->fecha }}</td>
                        <td><a href="/documentos/formatos_llenos_view/{{ $formato->id }}"><i style="color: #CCC;font-size:35px;" class="fa-solid fa-file-pdf"></i></a></td>
                        
                        <td id="adjuntos_btn_{{ $formato->id }}" ><button type="button" class="btn btn-light" onclick="showAdjuntos('adjuntos_formato_{{ $formato->id }}')"><i class="far fa-folder-open"></i></button></td>
                        <td id="adjuntos_formato_{{ $formato->id }}" class="td_adjuntos" style="display:none">
                            @php
                            $i = 0;
                            $adjuntos = $formato->getAdjuntos();
                            
                            foreach ($adjuntos as $adjunto) 
                            {
                                
                                $i++;
                                if(strpos($adjunto, 'jpg') !== false || strpos($adjunto, 'gif') !== false || strpos($adjunto, 'jpeg') !== false || strpos($adjunto, 'png') !== false)
                                {
                                    //es imagen
                                    echo "<br>";
                                    echo "<div class='img_card col-lg-5' >";
                                    echo "    <div class='img_card_top'>";
                                    echo "        <h6><b>Imagen #".$adjunto."</b></h6>"; 
                                    echo "    </div>";
                                    echo "    <img src_aux='".asset($adjunto)."'>";
                                    echo "</div>";
                                }
                                else
                                {
                                    // es archivo
                                    echo "<br>";
                                    echo "<div class='img_card col-lg-12' style='padding:10px'>";
                                    echo "    <div class='img_card_top'>";
                                    echo "        <h6><b>Archivo:</b></h6>"; 
                                    echo "    </div>";
                                    echo "    <p><a href='".asset($adjunto)."'><i class='fas fa-arrow-circle-down'></i></a></p>";
                                    echo "</div>";
                                }
                            }
                            @endphp
                        </td>
                        @if ( $nivel > 1) 

                        <td><button class="btn btn-primary" onclick="editar({{ $formato->id }})"><i class="fa-solid fa-pen-to-square"></i></button></td>
                        <td><button class="btn btn-success" onclick="eliminar({{ $formato->id }})"><i class="fa-solid fa-xmark"></i></button></td>
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
        $("#txtFecha").val(""); 
        $("#txtArchivo").val(""); 
        $("#txtDescripcion").val(""); 
        $("#formato_lleno_id").val(""); 
    }

    function editar(id)
    {
        limpiarForm();
        $.ajax({url: "/documentos/formatos_llenos/"+id,context: document.body}).done(function(result) 
        {
            $("#txtCodigo").val(result["codigo"]); 
            $("#txtTitulo").val(result["titulo"]); 
            $("#txtFecha").val(result["fecha"].split(" ")[0]); 
            $("#txtArchivo").val(""); 
            $("#txtDescripcion").val(result["descripcion"]); 
            $("#formato_lleno_id").val(result["id"]); 
            $("#frm_nuevo").show(); 
        });
    }

    function eliminar(id)
    {
        if(!confirm("Desea eliminar el registro?" ))
        {
            return;
        }
        $.ajax({url: "/documentos/formatos_llenos_delete/"+id,context: document.body}).done(function(result) 
        {
            showModal('Notificación','Registro eliminado!');
            window.location.reload();
        });
    }
    function showAdjuntos(content_row)
    {
        var html = $("#"+content_row).html();  
        showModal("Adjuntos",html.replace(/src_aux/g, "src"));
    }
    function filtrar()
    {
        var value = $("#txtQuickSearch").val().toLowerCase();
        
        $("#tbl_formatos tr").filter(function() 
        {
            $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value) > -1 
                )
        });
    }



</script>
@endsection