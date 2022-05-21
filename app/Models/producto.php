<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;

    protected $fillable = ['desc'];

    public function actividades()
    {
        return $this->belongsToMany(actividad::class, 'actividad_productos');
    }

    public function cpcus()
    {
        return $this->belongsToMany(cpcu::class, 'cpcu_productos');
    }

    public function saclaps()
    {
        return $this->belongsToMany(saclap::class, 'saclap_productos');
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
