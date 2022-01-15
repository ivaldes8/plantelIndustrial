<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saclap extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'desc'];

    public function producto()
    {
        return $this->belongsTo(producto::class);
    }
}
