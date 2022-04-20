<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indicador extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'desc'];

    public function productos()
    {
        return $this->belongsToMany(producto::class, 'indicador_entidad_plan_productos');
    }
}
