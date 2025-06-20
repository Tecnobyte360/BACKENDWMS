<?php

namespace App\Models\EvaluacionProveedor;

use Illuminate\Database\Eloquent\Model;

class EvaluacionOrdenCompra extends Model
{
    protected $table = 'evaluacion_orden_compras';

    protected $fillable = [
        'evaluacion_id',
        'orden_compra_id',
    ];

      public $timestamps = false;
}
