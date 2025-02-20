<?php
namespace App\Core\Services;

use App\Core\Conductor;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ConductorValidator {
    public static function validate(Conductor $conductor) {
        $validator = Validator::make($conductor->toArray(), [
            'email' => 'required|email|max:255|unique:Conductor,email',
            'contrasena' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}