<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plan extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id','indicador_id','entidad_id','plan', 'year'];

    public function indicador()
    {
        return $this->hasOne(indicador::class, 'id', 'indicador_id');
    }

    public function producto()
    {
        return $this->hasOne(producto::class, 'id', 'producto_id');
    }

    public function entidad()
    {
        return $this->hasOne(entidad::class, 'id', 'entidad_id');
    }
}
