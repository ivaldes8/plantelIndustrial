<?php

namespace App\Rules;

use App\Models\actividad;
use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\saclap;
use App\Models\nae;
use App\Models\unidad;

class ValidateIndicadorUnidad implements Rule
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
        $codsArray = explode( '/', $value );

        $findUnidad = true;
        if(count( $codsArray ) > 1){
            $unidad = unidad::where('desc', $codsArray[1])->get();
            if(count($unidad) === 0){
                $findUnidad = false;
            }
        }

        if($findUnidad === true){
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
        return 'La unidad de medida falta o no se encuentra la unidad de medida especificada en la Base de Datos.';
    }
}
