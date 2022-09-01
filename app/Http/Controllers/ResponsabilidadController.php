<?php

namespace App\Http\Controllers;

use App\Models\Responsabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SentNotification;
use App\Models\PerfilDePuesto;


class ResponsabilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responsabilidades = Responsabilidad::where('usuario_id',Auth::user()->id)->where('status', 'Pendiente')->get();
        $nivel = Auth::user()->getUserNivel();
        $fecha_actual = date("Y-m-d H:i:s");
        if(Auth::user()->tipo == "Administrador")
        {
            $responsabilidades = Responsabilidad::where('status', 'Pendiente')->get();
        }

        //actualizar el estado de las 

        foreach ($responsabilidades as $responsabilidad) 
        {
            if($responsabilidad->status == "Pendiente" && $responsabilidad->fecha_de_expiracion < $fecha_actual)
            {
                $responsabilidad->status = "Expirada";
                // $responsabilidad->save();
            }
        }

        $usuarios = User::all();
        $perfiles = PerfilDePuesto::all();

        return view('notificaciones.responsabilidades', [
            'responsabilidades' => $responsabilidades,
            'usuarios' => $usuarios,
            'perfiles' => $perfiles,
            'nivel' => $nivel
        ]);
    }

    public function store(Request $request)
    {
        $usuarios_ids = explode(",",$request->txtUsuarios);
        
        foreach ($usuarios_ids as $usuario) 
        {
            if(is_numeric($usuario))
            {
                $registro = new Responsabilidad;
                $registro->usuario_id = $usuario;
                $registro->tarea = $request->txtTarea ?? "";
                $registro->descripcion = $request->txtDescripcion ?? "";
                $registro->periocidad = $request->txtPeriodo ?? "";
                $tiene_fecha = ($request->txtFecha != "");
                $registro->status = 'Pendiente';
                $registro->documento = '';
                //$registro->padre = 0;

                if(!$tiene_fecha)
                {
                    $registro->fecha_de_expiracion = $registro->getSiguienteExpiracion();                    
                }
                else
                {
                    $registro->fecha_de_expiracion = $request->txtFecha;
                }

                $registro->save();
                //Mail::to($registro->usuario()->email)->send(new SentNotification($registro));
            }
        }
        return redirect('/');
    }
    public function destroy(Responsabilidad $responsabilidad)
    {
        // $hijos = Responsabilidad::where('padre',$responsabilidad->id)->get();
        // foreach ($hijos as $hijo) 
        // {
        //     $hijo->delete();
        // }
        $responsabilidad->delete();
    }
}
