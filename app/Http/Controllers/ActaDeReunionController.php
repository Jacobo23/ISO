<?php

namespace App\Http\Controllers;

use App\Models\ActaDeReunion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActaDeReunionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nivel = Auth::user()->getUserNivel();
        $actas_de_reunion = ActaDeReunion::all();
        return view('inicio.actas_de_reunion', [
            'actas_de_reunion' => $actas_de_reunion,
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
        if(isset($request->acta_id))
        {
            $registro = ActaDeReunion::find($request->acta_id);
            if($registro)
            {
                $update = true;
            }
        }
        
        if($update) // en caso de ser update
        {
            if($_FILES['file']['name'] == "") 
            {
                $registro->entidad = $request->txtEntidad ?? "";
                // $registro->folio = $request->txtFolio ?? "";
                $registro->lugar = $request->txtLugar ?? "";
                $registro->fecha = $request->txtFecha;
                $registro->estado = $request->txtEstado ?? "";
                $registro->objetivo = $request->txtObjetivo ?? "";
                $registro->save();
            }
            else
            {
                $registro->entidad = $request->txtEntidad ?? "";
                // $registro->folio = $request->txtFolio ?? "";
                $registro->lugar = $request->txtLugar ?? "";
                $registro->fecha = $request->txtFecha;
                $registro->estado = $request->txtEstado ?? "";
                $registro->objetivo = $request->txtObjetivo ?? "";

                if($registro->save())
                {
                    $path = 'public/Archivos/Actas_de_Reunion/' . $registro->id . '.pdf';
                    $path_storage = 'storage/Archivos/Actas_de_Reunion/' . $registro->id . '.pdf';

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
            $registro = new ActaDeReunion;
            $registro->entidad = $request->txtEntidad ?? "";
            // $registro->folio = $request->txtFolio ?? "";
            $registro->lugar = $request->txtLugar ?? "";
            $registro->fecha = $request->txtFecha;
            $registro->estado = $request->txtEstado ?? "";
            $registro->objetivo = $request->txtObjetivo ?? "";
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
                    $path = 'public/Archivos/Actas_de_Reunion/' . $registro->id . '.pdf';
                    $path_storage = 'storage/Archivos/Actas_de_Reunion/' . $registro->id . '.pdf';
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
        return redirect('/inicio/actas_de_reunion');

    }

    public function show(string $id)
    {
        $acta_de_reunion = ActaDeReunion::find($id);
        return $acta_de_reunion;
    }

    public function edit(ActaDeReunion $acta_de_reunion)
    {
        //
    }

    public function destroy(ActaDeReunion $acta_de_reunion)
    {
        $path = $acta_de_reunion->path;
        if($acta_de_reunion->delete())
        {
            Storage::delete($path);
        }
    }

    public function viewActaDeReunion(ActaDeReunion $acta_de_reunion)
    {
        //en el contexto de laravel el archivo es accesible desde el directorio "public" 
        //pero aqui usaremos funciones de PHP nativas, por lo tanto debemos usar el path hacia el directorio "storage"
        //esto->                    public/Archivos/Actas_de_Reunion/123.pdf
        //se convierte en esto ->   storage/Archivos/Actas_de_Reunion/123.pdf
        if($acta_de_reunion->path != "")
        {
            $arr = explode('/',$acta_de_reunion->path);
            $file_name = $arr[count($arr)-1];
            $path = "storage/Archivos/Actas_de_Reunion/" . $file_name;
            if(file_exists($path))
            {
                return response()->file($path);
            }
        }
        return "No hay archivo";
    }
}
