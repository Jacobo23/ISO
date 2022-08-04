<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Responsabilidad extends Model
{
    use HasFactory;
    // enum DataType: string Periodos {
         
    //     case Diario = 'diario;';
    //     case Semanal = 'semanal;';
    //     case Mensual = 'mensual;';
    //     case Trimestral = 'trimestral;';
    //     case Cuatrimestral = 'cuatrimestral;';
    //     case Semestral = 'semestral;';
    //     case Anual = 'anual;';
    // }
    public function usuario()
    {
        return User::find($this->usuario_id);
    }
    public function getSiguienteExpiracion()
    {
        switch ($this->periocidad) 
        {
            case '':
                return date('Y-m-d H:i:s'); 
                break;
            case 'diario':
                return date('Y-m-d H:i:s', strtotime($this->fecha_de_expiracion. ' + 1 days')); 
                break;
            case 'semanal':
                return date('Y-m-d H:i:s', strtotime($this->fecha_de_expiracion. ' + 7 days'));
                break;
            case 'mensual':
                return date('Y-m-d H:i:s', strtotime($this->fecha_de_expiracion. ' + 1 month')); 
                break;
            case 'trimestral':
                return date('Y-m-d H:i:s', strtotime($this->fecha_de_expiracion. ' + 3 months')); 
                break;
            case 'cuatrimestral':
                return date('Y-m-d H:i:s', strtotime($this->fecha_de_expiracion. ' + 4 months')); 
                break;
            case 'semestral':
                return date('Y-m-d H:i:s', strtotime($this->fecha_de_expiracion. ' + 6 months')); 
                break;
            case 'anual':
                return date('Y-m-d H:i:s', strtotime($this->fecha_de_expiracion. ' + 1 year')); 
                break;

            default:
                return $this->fecha_de_expiracion;
                break;
        }
    }
}
