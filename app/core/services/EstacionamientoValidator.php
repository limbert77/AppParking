<?php
namespace App\Core\Services;

use App\Core\Estacionamiento;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class EstacionamientoValidator {
    public static function validate(Estacionamiento $estacionamiento) {
        $validator = Validator::make($estacionamiento->toArray(), [
            'nombre' => 'required|string|max:80',
            'direccion' => 'required|string|max:80',
            'latitud' => 'required|string|max:80',
            'longitud' => 'required|string|max:80',
            'capacidad_automoviles' => 'required|integer|min:1',
            'capacidad_colectivos' => 'required|integer|min:1',
            'tarifa_automovil' => 'required|min:0|max:999',
            'tarifa_colectivo' => 'required|min:0|max:999',
            'estado' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
