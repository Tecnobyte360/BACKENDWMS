<?php

namespace App\Models\Proveedores;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class EvaluacionProveedor extends Model
{
    protected $table = 'evaluacion_proveedors';

   protected $fillable = [
    'cuatrimestre',
    'fecha_evaluacion',
    'centro_costo_id',
    'proveedor_id',
    'evaluador_id',
    'cumplimiento_entrega',
    'calidad_servicio',
    'garantia_soporte',
    'precio',
    'capacidad_respuesta',
    'observaciones',
];

    /**
     * Relación con el evaluador (usuario del sistema)
     */
    public function evaluador()
    {
        return $this->belongsTo(User::class, 'evaluador_id');
    }

       public $timestamps = false;
}
