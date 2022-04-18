<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\saclap;
use App\Models\nae;

class ValidateEntidadesProducto implements Rule
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
        // dd(explode( '/', $value ));
        $reusArray = explode( '/', $value );
        if(count($reusArray) === 0){
            return true;
        }
        $findAll = true;
        for ($i=0; $i < count($reusArray); $i++) {
           $entidad = entidad::where('codREU', $reusArray[$i])->get();
           if(count($entidad) === 0){
               $findAll = false;
           }
        }
        if($findAll === true){
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
        return 'Uno de estos códigos REU de las entidades :input no se encuentran registrados en la base de datos cerca de :attribute.';
    }
}
