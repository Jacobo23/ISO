<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsabilidad;


class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::where('tipo','Responsable')->orWhere('tipo','Administrador')->get();
        $documentos = Documento::all();
        $nivel = Auth::user()->getUserNivel();
        $usuario_logeado = Auth::user();

        $responsabilidades = Responsabilidad::where('usuario_id',Auth::user()->id)->where('status', 'Pendientes')->get();
        if(Auth::user()->tipo == "Administrador")
        {
            $responsabilidades = Responsabilidad::where('status', 'Pendiente')->get();
        }

        //$directorios = Storage::allDirectories("public");
        // $directorios = [
        //     "Actas_de_Reunion",
        //     "Perfiles_de_Puesto",
        //     "Formatos_Llenos",
        //     "SGC",
        //     "SGC/Instrucciones",
        //     "SGC/Procedimientos",
        //     "SGC/Seguridad",
        //     "SGC/Calidad",
        // ];
        return view('documentos.documentos', [
            'usuarios' => $usuarios,
            'documentos' => $documentos,
            'nivel' => $nivel,
            'usuario_logeado' => $usuario_logeado,
            'responsabilidades' => $responsabilidades
        ]);
    }

    public function historial()
    {
        // $usuarios = User::where('tipo','Responsable')->orWhere('tipo','Administrador')->get();
        // $documentos = Documento::all();
        // $nivel = Auth::user()->getUserNivel();
        $usuario_logeado = Auth::user();

        // $responsabilidades = Responsabilidad::where('usuario_id',Auth::user()->id)->where('status', 'Pendientes')->get();
        // if(Auth::user()->tipo == "Administrador")
        // {
        //     $responsabilidades = Responsabilidad::where('status', 'Pendiente')->get();
        // }

        //$directorios = Storage::allDirectories("public");
        // $directorios = [
        //     "Actas_de_Reunion",
        //     "Perfiles_de_Puesto",
        //     "Formatos_Llenos",
        //     "SGC",
        //     "SGC/Instrucciones",
        //     "SGC/Procedimientos",
        //     "SGC/Seguridad",
        //     "SGC/Calidad",
        // ];
        return view('documentos.historial', [
            'usuario_logeado' => $usuario_logeado
        ]);
    }

    


    public function getDirectoryArrays($rutas)
    {
        $result = [];
        $count = count($rutas);
        for ($i=$count-1; $i > -1; $i--) 
        { 
            array_push($result,explode("/",$rutas[$i]));
        }
        return $result;
    }

    public function getDirectoryName($path)
    {
        $arr = explode("/",$path);
        return $arr[count($arr)-1];
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
        $update = false;
        if(isset($request->documento_id))
        {
            $registro = Documento::find($request->documento_id);
            if($registro)
            {
                $update = true;
            }
        }
        
        if(!$update) // en caso de no ser update
        {
            $registro = new Documento;
        }

        $registro->codigo = $request->txtCodigo ?? "";
        $registro->titulo = $request->txtTitulo ?? "";
        $registro->rev = $request->txtRev ?? "";
        $registro->fecha = $request->txtFecha;
        $registro->responsable_id = $request->txtResponsable;
        $registro->estado = $request->txtEstado;
        $registro->activo = isset($request->chkActivo);

        if($registro->save())
        {
            if($_FILES['file']['name'] != "") 
            {
                $version = 'Final';
                $dir = 'public/Archivos/Documentos/' . $registro->id . '/' . $version;
                $dir_storage = 'storage/Archivos/Documentos/' . $registro->id . '/' . $version;
                $path = $dir . '/' . $registro->id . '-' . $registro->titulo . '.' . $request->file('file')->extension();
                $path_storage = $dir_storage . '/' . $registro->id . '-' . $registro->titulo . '.' . $request->file('file')->extension();
                
                if(file_exists($dir_storage))
                {
                    // si ya hay un archivo con el mismo nombre se va a remplazar
                    Storage::deleteDirectory($dir);
                }
                Storage::put($path, file_get_contents($request->file('file')));
                
            }
            if($_FILES['fileSource']['name'] != "") 
            {
                $version = 'Modificable';
                $dir = 'public/Archivos/Documentos/' . $registro->id . '/' . $version;
                $dir_storage = 'storage/Archivos/Documentos/' . $registro->id . '/' . $version;
                $path = $dir . '/' . $registro->id . '-' . $registro->titulo . '.' . $request->file('fileSource')->extension();
                $path_storage = $dir_storage . '/' . $registro->id . '-' . $registro->titulo . '.' . $request->file('fileSource')->extension();
                
                if(file_exists($dir_storage))
                {
                    // si ya hay un archivo con el mismo nombre se va a remplazar
                    Storage::deleteDirectory($dir);
                }
                Storage::put($path, file_get_contents($request->file('fileSource')));
                
            }
            if($_FILES['fileWM']['name'] != "") 
            {
                $version = 'Marca_de_agua';
                $dir = 'public/Archivos/Documentos/' . $registro->id . '/' . $version;
                $dir_storage = 'storage/Archivos/Documentos/' . $registro->id . '/' . $version;
                $path = $dir . '/' . $registro->id . '-' . $registro->titulo . '.' . $request->file('fileWM')->extension();
                $path_storage = $dir_storage . '/' . $registro->id . '-' . $registro->titulo . '.' . $request->file('fileWM')->extension();
                
                if(file_exists($dir_storage))
                {
                    // si ya hay un archivo con el mismo nombre se va a remplazar
                    Storage::deleteDirectory($dir);
                }
                Storage::put($path, file_get_contents($request->file('fileWM')));
                
            }
            //Responsabilidades
            if(isset($request->txtResponsabilidad))
            {
                $responsabilidad = Responsabilidad::find($request->txtResponsabilidad);

                if($responsabilidad)
                {
                
                $responsabilidad->status = 'Completa';
                $responsabilidad->documento = 'Doc:'.$registro->id;
                $responsabilidad->save();
                //si es periodica debe agregarse una nueva responsabilidad con los mismos datos pero distinta fecha
                if($responsabilidad->periocidad != "")
                {
                    $responsabilidad2 = new Responsabilidad;
                    $responsabilidad2->usuario_id = $responsabilidad->usuario_id;
                    $responsabilidad2->tarea = $responsabilidad->tarea;
                    $responsabilidad2->descripcion = $responsabilidad->descripcion;
                    $responsabilidad2->periocidad = $responsabilidad->periocidad;
                    $responsabilidad2->status = 'Pendiente';
                    $responsabilidad2->documento = '';
                    $responsabilidad2->fecha_de_expiracion = $responsabilidad->getSiguienteExpiracion();
                    $responsabilidad2->save();
                    //$responsabilidad->padre = 0;
                }
                }
            }
        }
        return redirect('/documentos/documentos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $documento = Documento::find($id);
        return $documento;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        $id = $documento->id;
        
        if($documento->delete())
        {
            Storage::deleteDirectory('public/Archivos/Documentos/' . $id);
        }
    }

    public function viewDocumento(Documento $documento)
    {
        $path = 'storage/Archivos/Documentos/' . $documento->id . "/Final/";
        if(file_exists($path))
        {
            $file = scandir($path);
            // tiene que ser mayor de 2 porque los primeros 2 archivos encontrados son = .  y  ..
            if(count($file) > 2)
            {
                return response()->file($path . $file[2]);
            }
        }
        return "No hay archivo";
    }
    public function viewDocumentoMod(Documento $documento)
    {
        $path = 'storage/Archivos/Documentos/' . $documento->id . "/Modificable/";
        if(file_exists($path))
        {
            $file = scandir($path);
                        // tiene que ser mayor de 2 porque los primeros 2 archivos encontrados son = .  y  ..

            if(count($file) > 2)
            {
                return response()->file($path . $file[2]);
            }
        }
        return "No hay archivo";
    }
    public function viewDocumentoWMA(Documento $documento)
    {
        $path = 'storage/Archivos/Documentos/' . $documento->id . "/Marca_de_agua/";
        if(file_exists($path))
        {
            $file = scandir($path);            // tiene que ser mayor de 2 porque los primeros 2 archivos encontrados son = .  y  ..

            if(count($file) > 2)
            {
                return response()->file($path . $file[2]);
            }
        }
        return "No hay archivo";
    }

    public function getDocumentoActivo($codigo)
    {
        $nivel = Auth::user()->getUserNivel();
        $documento = Documento::where('codigo',$codigo)->where('activo',true)->first();
        if($documento && $nivel > 0 && $nivel < 4)
        {
            switch ($nivel) 
            {
                case 1:
                    return $this->viewDocumentoWMA($documento);
                    break;
                case 2:
                    return $this->viewDocumento($documento);
                    break;
                case 3:
                    return $this->viewDocumento($documento);
                    break;
            }
        }
        else
        {
            return "No hay archivo";
        }
    }
}
