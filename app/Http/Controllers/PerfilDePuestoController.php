<?php

namespace App\Http\Controllers;

use App\Models\PerfilDePuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerfilDePuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles = PerfilDePuesto::all();
        $nivel = Auth::user()->getUserNivel();
        return view('liderazgo.perfiles_de_puesto', [
            'perfiles__de_puesto' => $perfiles,
            'nivel' => $nivel
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
        $update = false;
        if(isset($request->perfil_id))
        {
            $registro = PerfilDePuesto::find($request->perfil_id);
            if($registro)
            {
                $update = true;
            }
        }

        if($update) // en caso de ser update
        {
            if($_FILES['file']['name'] == "") 
            {
                $registro->codigo = $request->txtCodigo ?? "";
                $registro->nombre = $request->txtNombre ?? "";
                $registro->rev = $request->txtRev ?? "";
                $registro->fecha = $request->txtFecha;
                $registro->save();
            }
            else
            {
                $registro->codigo = $request->txtCodigo ?? "";
                $registro->nombre = $request->txtNombre ?? "";
                $registro->rev = $request->txtRev ?? "";
                $registro->fecha = $request->txtFecha;

                

                if($registro->save())
                {
                    $path = 'public/Archivos/Perfiles_de_Puesto/' . $registro->id . '.pdf';
                    $path_storage = 'storage/Archivos/Perfiles_de_Puesto/' . $registro->id . '.pdf';

                    $registro->path = $path;
                    $registro->save();

                    if(file_exists($path_storage))
                    {
                        // si ya hay un archivo con el mismo nombre se va a remplazar
                        Storage::delete($path);
                    }
                    Storage::put($path, file_get_contents($request->file('file')));
                }
            }
        }
        else
        {
            //es un nuevo registro
            $registro = new PerfilDePuesto;
            $registro->codigo = $request->txtCodigo ?? "";
            $registro->nombre = $request->txtNombre ?? "";
            $registro->rev = $request->txtRev ?? "";
            $registro->fecha = $request->txtFecha;
            if($_FILES['file']['name'] == "") 
            {
                $path = "";
                $registro->path = $path;
                $registro->save();
            }
            else
            {
                if($registro->save())
                {
                    $path = 'public/Archivos/Perfiles_de_Puesto/' . $registro->id . '.pdf';
                    $path_storage = 'storage/Archivos/Perfiles_de_Puesto/' . $registro->id . '.pdf';

                    $registro->path = $path;
                    $registro->save();
                    if(file_exists($path_storage))
                    {
                        // si ya hay un archivo con el mismo nombre se va a remplazar
                        Storage::delete($path);
                    }
                    Storage::put($path, file_get_contents($request->file('file')));
                }
            }
        }
        return redirect('/liderazgo/perfiles_de_puesto');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PerfileDePuesto  $perfileDePuesto
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $perfileDePuesto = PerfilDePuesto::find($id);
        return $perfileDePuesto;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PerfileDePuesto  $perfileDePuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(PerfilDePuesto $perfil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PerfileDePuesto  $perfileDePuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PerfilDePuesto $perfil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerfileDePuesto  $perfileDePuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(PerfilDePuesto $perfil)
    {
        $path = $perfil->path;
        if($perfil->delete())
        {
            Storage::delete($path);
        }
    }

    public function viewPerfilDePuesto(PerfilDePuesto $perfil)
    {
        //en el contexto de laravel el archivo es accesible desde el directorio "public" 
        //pero aqui usaremos funciones de PHP nativas, por lo tanto debemos usar el path hacia el directorio "storage"
        //esto->                    public/Archivos/Actas_de_Reunion/123.pdf
        //se convierte en esto ->   storage/Archivos/Actas_de_Reunion/123.pdf
        if($perfil->path != "")
        {
            $arr = explode('/',$perfil->path);
            $file_name = $arr[count($arr)-1];
            $path = "storage/Archivos/Perfiles_de_Puesto/" . $file_name;
            if(file_exists($path))
            {
                return response()->file($path);
            }
        }
        return "No hay archivo";
    }
}
