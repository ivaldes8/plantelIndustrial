<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indicadorProducto extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id','indicador_id','value', 'date'];

    public function indicador()
    {
        return $this->hasOne(indicador::class, 'id', 'indicador_id');
    }
}
