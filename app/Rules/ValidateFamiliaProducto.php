<?php

namespace App\Rules;

use App\Models\actividad;
use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\familia;
use App\Models\saclap;
use App\Models\nae;

class ValidateFamiliaProducto implements Rule
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

        $familia = familia::where('name',$value)->get();


        if(count($familia) > 0){
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
        return 'La familia de productos: :input no existe en la base de datos cerca de :attribute.';
    }
}
