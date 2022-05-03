<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;

    protected $fillable = ['desc', 'cpcu_id', 'saclap_id', 'nae_id'];

    public function cpcu()
    {
        return $this->hasOne(cpcu::class, 'id', 'cpcu_id');
    }

    public function saclap()
    {
        return $this->hasOne(saclap::class, 'id', 'saclap_id');
    }

    public function cnae()
    {
        return $this->hasOne(nae::class, 'id', 'nae_id');
    }

    public function actividades()
    {
        return $this->belongsToMany(actividad::class, 'actividad_productos');
    }

    public function indicadores()
    {
        return $this->belongsToMany(indicador::class, 'indicador_entidad_plan_productos');
    }

    public function informacion()
    {
        return $this->hasMany(indicadorEntidadPlanProducto::class, 'producto_id', 'id');
    }

    public function entidades()
    {
        return $this->belongsToMany(entidad::class, 'indicador_entidad_plan_productos');
    }

    public function familia()
    {
        return $this->belongsToMany(familia::class, 'familia_productos');
    }
}
