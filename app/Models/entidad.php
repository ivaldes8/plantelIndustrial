<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entidad extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'codREU', 'dpa', 'org_id', 'osde_id'];

    public function organismo()
    {
        return $this->hasOne(organismo::class, 'id', 'org_id');
    }

    public function osde()
    {
        return $this->hasOne(osde::class, 'id', 'osde_id');
    }

    public function productos()
    {
        return $this->belongsToMany(producto::class, 'entidad_productos');
    }
}


