<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\saclap;
use App\Models\nae;

class RepeatCNAEProducto implements Rule
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

        $nae = nae::where('codigo', $value)->get();
        if(count($nae) > 0){
            $producto = producto::where('nae_id',$nae[0]->id)->get();
        }
        if(count($nae) > 0 && count($producto) === 0){
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
        return 'Ya existen productos con el código cnae :input en la base de datos ';
    }
}
