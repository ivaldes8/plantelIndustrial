<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\saclap;
use App\Models\nae;

class RepeatCPCUProducto implements Rule
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

        $cpcu = cpcu::where('codigo', $value)->get();
        if(count($cpcu) === 0){
            return true;
        }
        if(count($cpcu) > 0){
            $producto = producto::where('cpcu_id',$cpcu[0]->id)->get();
        }
        if(count($cpcu) > 0 && count($producto) === 0){
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
        return 'Ya existen productos con el código cpcu :input en la base de datos ';
    }
}
