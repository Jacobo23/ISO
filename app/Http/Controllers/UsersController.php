<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PerfilDePuesto;
use App\Models\TipoDeUsuario;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios = User::all();
        $perfiles = PerfilDePuesto::all();
        $tipos = TipoDeUsuario::all();
        return view('usuarios.perfiles_de_usuario', [
            'usuarios' => $usuarios,
            'perfiles' => $perfiles,
            'tipos' => $tipos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $registro = User::where('name',$request->txtUser)->first();
        if($registro) // en caso de ser update
        {
            $registro->email = $request->txtEmail;
            $registro->perfil = $request->txtPerfil;
            $registro->tipo = $request->txtTipo;
            $registro->activo = isset($request->chkActivo);
            $registro->save();
        }
        else
        {
            //es un nuevo registro
            $registro = new User;
            $registro->name = $request->txtUser;
            $registro->email = $request->txtEmail;
            $registro->password = "";
            $registro->perfil = $request->txtPerfil;
            $registro->tipo = $request->txtTipo;
            $registro->activo = isset($request->chkActivo);
            $registro->save();
        }
        return redirect('/usuarios/perfiles_de_usuario');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
