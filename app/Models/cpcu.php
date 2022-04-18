<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cpcu extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'codigo', 'desc'];

    public function producto()
    {
        return $this->belongsTo(producto::class);
    }
}
