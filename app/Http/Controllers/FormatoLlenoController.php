<?php

namespace App\Http\Controllers;

use App\Models\FormatoLleno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Documento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FormatoLlenoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$formatos_llenos = FormatoLleno::all(); // solo deben aparecer los formatos de los que el usuario sea responsable

        //obtener un array de los codigo de formato de los que eres responsable
        $usuario_logeado = Auth::user();
        $nivel = Auth::user()->getUserNivel();
        if($usuario_logeado->tipo == "Administrador")
        {
            $formatos_llenos = FormatoLleno::all();
        }
        else
        {
            $codigos = Documento::where('responsable_id',$usuario_logeado->id)->pluck('codigo');
            $formatos_llenos = FormatoLleno::whereIn('codigo',$codigos)->get();
        }
        
        return view('documentos.formatos_llenos', [
            'formatos_llenos' => $formatos_llenos,
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
        $registro = false;
        if(isset($request->formato_lleno_id))
        {
            $registro = FormatoLleno::find($request->formato_lleno_id);
        }
        
        if(!$registro) // en caso de ser update
        {
            $registro = new FormatoLleno;
        }

        $registro->codigo = $request->txtCodigo ?? "";
        $registro->titulo = $request->txtTitulo ?? "";
        $registro->fecha = $request->txtFecha;
        $registro->descripcion = $request->txtDescripcion ?? "";

        if($registro->save())
        {
            //archivo
            if($_FILES['file']['name'] != "") 
            {
                $path_archivo_public = 'public/Archivos/Formatos_Llenos/' . $registro->id . '/' . $registro->id . ".pdf";
                $path_archivo_storage = 'storage/Archivos/Formatos_Llenos/' . $registro->id . '/' . $registro->id . ".pdf";

                //$path_adjuntos = 'storage/Archivos/Formatos_Llenos/' . $registro->id . '/adjuntos/' . $request->file('file')->extension();

                if(file_exists($path_archivo_storage))
                {
                    // si ya hay un archivo con el mismo nombre se va a remplazar
                    Storage::delete($path_archivo_public);
                }
                Storage::put($path_archivo_public, file_get_contents($request->file('file')));
            }

            if($request->file('evidencias') !== null) 
            {
                //adjuntos
                if(file_exists('storage/Archivos/Formatos_Llenos/' . $registro->id . '/adjuntos'))
                {
                    // si ya hay un archivo con el mismo nombre se va a remplazar
                    Storage::deleteDirectory('public/Archivos/Formatos_Llenos/' . $registro->id . '/adjuntos');
                }
                $i = 0;
                foreach ($request->file('evidencias') as $file) 
                {
                    $i++;
                    $path_adjuntos_public = '/public/Archivos/Formatos_Llenos/' . $registro->id . '/' . 'adjuntos/' . $i . "." . $file->extension();    
                    Storage::put($path_adjuntos_public, file_get_contents($file));
                }
            }
        }


        return redirect('/documentos/formatos_llenos');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\formato_lleno  $formato_lleno
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $formato = FormatoLleno::find($id);
        return $formato;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formato_lleno  $formato_lleno
     * @return \Illuminate\Http\Response
     */
    public function edit(formato_lleno $formato_lleno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formato_lleno  $formato_lleno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, formato_lleno $formato_lleno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formato_lleno  $formato_lleno
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormatoLleno $formato)
    {
        $id = $formato->id;
        if($formato->delete())
        {
            Storage::deleteDirectory('public/Archivos/Formatos_Llenos/' . $id);
        }
    }

    public function viewFormatoLlenoDeReunion(FormatoLleno $formato)
    {
        $path_archivo_storage = 'storage/Archivos/Formatos_Llenos/' . $formato->id . '/' . $formato->id . ".pdf";

        if(file_exists($path_archivo_storage))
        {
            return response()->file($path_archivo_storage);
        }
        return "No hay archivo";
    }
}
