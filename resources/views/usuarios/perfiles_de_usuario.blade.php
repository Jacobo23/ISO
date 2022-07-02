@extends('layouts.common')
@section('headers')
@endsection
@section('content')
<!-- Page Heading -->
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perfiles de Usuarios
        </h2>
    </div>
</header>

<!-- Page Content -->
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

            <button class="btn btn-success" onclick="verForm()" >Nuevo <i class="fa-solid fa-plus"></i></button>
            <br>
            <div id="frm_nuevo" style="display:none;">

                <form action="/usuarios/perfiles_de_usuario_guardar" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">
                        <div class="col-lg-3 controlDiv" >
                            <label class="form-label">Usuario:</label>
                            <input type="text" class="form-control" id="txtUser" name="txtUser" value="" required>  
                        </div>
                        <div class="col-lg-3 controlDiv" >
                            <label class="form-label">Email:</label>
                            <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="" required>       
                        </div>
                        <div class="col-lg-3 controlDiv" >
                            <label class="form-label">Perfil:</label>
                            <select class="form-select" id = "txtPerfil" name = "txtPerfil" required>
                            @foreach ($perfiles as $perfil)
                                <option value="{{ $perfil->nombre }}">{{ $perfil->nombre }}</option>
                            @endforeach
                            </select>      
                        </div>
                        <div class="col-lg-2 controlDiv" >
                            <label class="form-label">Tipo:</label>
                            <select class="form-select" id = "txtTipo" name = "txtTipo" required>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->tipo }}">{{ $tipo->tipo }}</option>
                            @endforeach
                            </select>      
                        </div>
                        <div class="col-lg-1 controlDiv" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="chkActivo" id="chkActivo" name="chkActivo">
                                <label class="form-check-label">Estado</label>
                            </div>      
                        </div>
                    </div>
                    
                    
                    <input type="submit" class="btn btn-success" style="float:right;" value="Guardar">
                    
                </form>
                <button class="btn btn-danger" onclick="ocultarForm()" style="float:right; position:relative; left:-5px;">Cancelar</button> 
                <br>
            </div>

            

            <h5 class="separtor">Lista</h5>

            <table class="table tbl-reg table-sm table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Perfil</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Email</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->perfil }}</td>
                        <td>{{ $usuario->tipo }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>@if ($usuario->activo) Activo &nbsp;&nbsp;&nbsp; <i class="fas fa-check-square" style="color:green"></i> @else In-activo <i class="fa-solid fa-square-xmark" style="color:red"></i> @endif</td>
                        <td><button class="btn btn-success" onclick="editar({{ $usuario->id }})"><i class="fa-solid fa-pen-to-square"></i></button></td>
                        <td><button class="btn btn-success" onclick="eliminar({{ $usuario->id }})"><i class="fa-solid fa-xmark"></i></button></td>
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
        $("#txtUser").val(""); 
        $("#txtEmail").val(""); 
        $("#txtPerfil").val(""); 
        $("#txtTipo").val(""); 
        $("#chkActivo").prop('checked', false);
    }

    function editar(id)
    {
        limpiarForm();
        $.ajax({url: "/usuarios/perfiles_de_usuario/"+id,context: document.body}).done(function(result) 
        {
            $("#txtUser").val(result["name"]); 
            $("#txtEmail").val(result["email"]); 
            $("#txtPerfil").val(result["perfil"]); 
            $("#txtTipo").val(result["tipo"]); 
            $("#chkActivo").prop('checked', result["activo"]);
            $("#frm_nuevo").show(); 
            $("#txtUser").focus(); 

        });
    }

    function eliminar(id)
    {
        if(!confirm("Desea eliminar el registro?" ))
        {
            return;
        }
        $.ajax({url: "/usuarios/perfiles_de_usuario_delete/"+id,context: document.body}).done(function(result) 
        {
            showModal('Notificación','Registro eliminado!');
            window.location.reload();
        });
    }



</script>
@endsection