<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionSAP extends Model
{
    protected $table = 'configuracion_s_a_p_s';

    protected $fillable = [
        'base_url',
        'company_db',
        'username',
        'password',
        'route_id',
    ];

 public $timestamps = false;

}
