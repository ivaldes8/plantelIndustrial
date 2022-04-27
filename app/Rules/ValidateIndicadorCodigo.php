<?php

namespace App\Rules;

use App\Models\actividad;
use Illuminate\Contracts\Validation\Rule;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\indicador;
use App\Models\saclap;
use App\Models\nae;

class ValidateIndicadorCodigo implements Rule
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
        if(!$value){
            return true;
        }
        $codInd = explode( '/', $value );
        if(count($codInd) === 0){
            return true;
        }
        $findIndicador = true;
        if(count($codInd) > 1){
            $indicador = indicador::where('codigo', $codInd[0])->get();
            if(count($indicador) === 0){
                $findIndicador = false;
            }
        }

        if($findIndicador === true){
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
        return 'El codigo del indicador especificado no se encuentra en la base de datos';
    }
}
