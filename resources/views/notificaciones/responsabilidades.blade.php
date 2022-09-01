@extends('layouts.common')
@section('headers')
@endsection
@section('content')
<!-- Page Heading -->
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Responsabilidades
        </h2>
    </div>
</header>

<!-- Page Content -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

            @if ($nivel > 1) 
            <button class="btn btn-success" onclick="verForm()" >Nuevo <i class="fa-solid fa-plus"></i></button>
            @endif

            <br>
            <div id="frm_nuevo" style="display:none;">

                <form action="/notificaciones/responsabilidades_guardar" method="post" enctype="multipart/form-data">
                @csrf


                    <div class="row">
                        
                        <div class="col-lg-4 controlDiv" >
                            <label class="form-label">Tarea:</label>
                            <input type="text" class="form-control" id="txtTarea" name="txtTarea" value="" required/>  
                        </div>

                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Fecha de expiración:</label>
                            <input type="date" class="form-control" id="txtFecha" name="txtFecha" value=""/>
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Periodicidad:</label>
                            <select class="form-select" id = "txtPeriodo" name = "txtPeriodo">
                                <option value=""></option>
                                <option value="diario">diario</option>
                                <option value="semanal">semanal</option>
                                <option value="mensual">mensual</option>
                                <option value="trimestral">trimestral</option>
                                <option value="cuatrimestral">cuatrimestral</option>
                                <option value="semestral">semestral</option>
                                <option value="anual">anual</option>
                            </select>      
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción:</label>
                        <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2"></textarea>
                    </div>

                    <div class="row">

                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Usuario:</label>
                            <select class="form-select" id = "txtUsuario" onchange="addUserEvent()">
                                <option value=""></option>
                            @foreach ($usuarios as $usuario)
                                <option id="opt_usr_{{ $usuario->id }}" value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                            </select>      
                        </div>

                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Perfil:</label>
                            <select class="form-select" id = "txtPerfil" onchange="AddPorPerfil()">
                                <option value=""></option>
                            @foreach ($perfiles as $perfil)
                                <option value="{{ $perfil->nombre }}">{{ $perfil->nombre }}</option>
                            @endforeach
                            </select>      
                        </div>

                        <input type="hidden" name="txtUsuarios" id="txtUsuarios" value="" required/>

                    </div>
                    <br/>

                    <input type="submit" value="" id="btnSubmit" style="display:none;"/>
                    
                                        
                </form>

                <table class="table tbl-reg table-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Asignar a:</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="TrUsr">
                        <!-- <tr>
                            <td> Juan </td>
                            <td><button class="btn btn-danger" onclick="eliminar(this)"><i class="fa-solid fa-xmark"></i></button></td>
                        </tr> - Esto se utiliza en la funcion "llenarTableDeUsuarios()" -->
                    </tbody>
                </table>


                <button class="btn btn-success" onclick="enviarForm()" style="float:right;">Guardar</button> 

                <button class="btn btn-danger" onclick="ocultarForm()" style="float:right; position:relative; left:-5px;">Cancelar</button> 
                <br/>
            </div>

            

            <h5 class="separtor">Responsabilidades asignadas</h5>
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
                    <th scope="col">Tarea</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Creación</th>
                    <th scope="col">Expiración</th>
                    <th scope="col">Periodicidad</th>
                    <th scope="col">Status</th>
                    <th scope="col">documento</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="tbl_respos">
                    @foreach ($responsabilidades as $responsabilidad)
                    <tr @if ($responsabilidad->status == "Expirada") class="table-danger" @endif>
                        <td>{{ $responsabilidad->id }}</td>
                        <td>{{ $responsabilidad->tarea }}</td>
                        <td>{{ $responsabilidad->descripcion }}</td>
                        <td>{{ $responsabilidad->created_at }}</td>
                        <td>{{ $responsabilidad->fecha_de_expiracion }}</td>
                        <td>{{ $responsabilidad->periocidad }}</td>
                        <td>{{ $responsabilidad->status }}</td>
                        <td>{{ $responsabilidad->documento }}</td>
                        <td>{{ $responsabilidad->usuario()->name }}</td>
                        <td><button class="btn btn-danger" onclick="eliminarResponsabilidad({{ $responsabilidad->id }})"><i class="fa-solid fa-xmark"></i></button></td>
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
        $("#txtFolio").val(""); 
        $("#txtEntidad").val(""); 
        $("#txtFecha").val(""); 
        $("#txtLugar").val(""); 
        $("#txtEstado").val(""); 
        $("#txtArchivo").val(""); 
        $("#txtObjetivo").val(""); 
        // $("#acta_id").val(""); 
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

    function enviarForm()
    {
        if($("#txtUsuarios").val() == "")
        {
            showModal("Validación","Elija usuarios para hacer la notificación.");
            return;
        }
        $("#btnSubmit").click(); 
        //$("#frm_nuevo").submit(); 
    }

    function addUserEvent()
    {
        let Usuario = $("#txtUsuario").val();
        addUser(Usuario);
    }

    function addUser(user_id)
    {
        if(user_id != "")
        {
            if($("#txtUsuarios").val() == "")
            {
                $("#txtUsuarios").val(user_id);
            }
            else
            {
                let Usuarios = $("#txtUsuarios").val().split(",");
                let repetido = false;
                Usuarios.forEach(usuario => {
                    if(usuario == user_id)
                    {
                        repetido = true;
                    }
                });
                if(!repetido)
                {
                    $("#txtUsuarios").val($("#txtUsuarios").val() + "," + user_id);
                }
            }
            let Usuarios = $("#txtUsuarios").val().split(",");
            llenarTableDeUsuarios(Usuarios);
            
        }
    }

    function llenarTableDeUsuarios(usuarios_ids)
    {
        $("#TrUsr").html("");
        usuarios_ids.forEach(usuario => {
                $("#TrUsr").html($("#TrUsr").html() + "<tr id='row_usr_"+ usuario +"'><td>" + $("#opt_usr_" + usuario).html() + "</td><td><button class='btn btn-danger' onclick='eliminar(this)'><i class='fa-solid fa-xmark'></i></button></td></tr>");
            });
    }

    function eliminar(control)
    {
        let tr = control.parentElement.parentElement;
        let id = tr.id.split("_")[2];
        tr.remove();
        let Usuarios = $("#txtUsuarios").val().split(",");
        let new_usuarios = "";
        Usuarios.forEach(usuario => {
            if(usuario != id)
            {
                if(new_usuarios != "")
                {
                    new_usuarios += ",";
                }
                new_usuarios += usuario;
            }
        });
        $("#txtUsuarios").val(new_usuarios);
    }

    function AddPorPerfil()
    {
        let perfil = $("#txtPerfil").val();
        if(perfil != "")
        {
            $.ajax({url: "/notificaciones/getUsuariosPorPerfil/"+perfil,context: document.body}).done(function(response) 
            {
                let usuarios = response.split(",");
                usuarios.forEach(usuario => {
                    addUser(usuario);
                });
            });
        }
        
    }

    function eliminarResponsabilidad(id)
    {
        if(!confirm("Desea eliminar el registro?" ))
        {
            return;
        }
        $.ajax({url: "/notificaciones/responsabilidades_delete/"+id,context: document.body}).done(function(result) 
        {
            showModal('Notificación','Registro eliminado!');
            window.location.reload();
        });
    }

    function filtrar()
    {
        var value = $("#txtQuickSearch").val().toLowerCase();
        
        $("#tbl_respos tr").filter(function() 
        {
            $(this).toggle(
                    $(this).text().toLowerCase().indexOf(value) > -1 
                )
        });
    }





</script>
@endsection