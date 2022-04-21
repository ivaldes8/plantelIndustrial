<?php

namespace App\Rules;

use App\Models\actividad;
use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\saclap;
use App\Models\nae;

class ValidateIndicadorProducto implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if(!$value){
            return true;
        }
        $cpcu = cpcu::where('codigo', $value)->get();

        $producto = [];
        if(count($cpcu) > 0){
            $producto = producto::where('cpcu_id', $cpcu[0]->id)->get();

        }
        if(count($producto) > 0 && count($cpcu) > 0){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El codigo cpcu :input no se encuentra asociado a ningun producto en la base de datos cerca de: :attribute.';
    }
}
