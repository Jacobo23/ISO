<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PerfilDePuesto;

use Illuminate\Support\Facades\Mail;
use App\Mail\SentNotification;



class NotificationController extends Controller
{
    //
    public function index()
    {
        $notificaciones = Notification::where('usuario_id',Auth::user()->id)->get();
        $nivel = Auth::user()->getUserNivel();
        if(Auth::user()->tipo == "Administrador")
        {
            $notificaciones = Notification::all();
        }

        $usuarios = User::all();
        $perfiles = PerfilDePuesto::all();

        return view('notificaciones.notificaciones', [
            'notificaciones' => $notificaciones,
            'usuarios' => $usuarios,
            'perfiles' => $perfiles,
            'nivel' => $nivel
        ]);
    }
    public function getUsuariosPorPerfil($perfil)
    {
        //
        $notificaciones = Notification::all();

        $usuarios = User::where('perfil',$perfil)->get();

        $array = [];
        foreach ($usuarios as $usuario) {
            array_push($array, $usuario->id);
        }
        $ret = implode(",",$array);

        return $ret;
    }
    public function store(Request $request)
    {
        $usuarios_ids = explode(",",$request->txtUsuarios);
        foreach ($usuarios_ids as $usuario) 
        {
            if(is_numeric($usuario))
            {
                $registro = new Notification;
                $registro->usuario_id = $usuario;
                $registro->asunto = $request->txtAsunto ?? "";
                $registro->descripcion = $request->txtDescripcion ?? "";
                $registro->fecha_de_expiracion = $request->txtFecha;
                $registro->save();
                Mail::to($registro->usuario()->email)->send(new SentNotification($registro));
            }
        }
        return redirect('/');
    }
    public function destroy(Notification $notificacion)
    {
        $notificacion->delete();
    }

}
