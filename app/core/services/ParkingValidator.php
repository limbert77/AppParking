<?php
namespace App\Core\Services;

use App\Core\Parking;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ParkingValidator {
    public static function validate(Parking $parking) {
        $validator = Validator::make($parking->toArray(), [
            'ingreso' => 'required|date',
            'salida' => 'required|date|after:ingreso',
            'id_est' => 'required|integer|exists:Estacionamiento,id_est',
            'id_vehi' => 'nullable|integer|exists:Vehiculo,id_vehi',
            'total_pagar' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
