<?php 
namespace App\Core\Services;

use App\Core\Conductor;
use App\Models\ConductorModel;
use App\Core\Services\ConductorValidator;

class ConductorService {
    
    public function add(Conductor $conductor) {
        ConductorValidator::validate($conductor); // Validar antes de insertar
        return ConductorModel::create($conductor->toArray());
    }

    public function getConductores() {
        return ConductorModel::get();
    }

    public function findById($id) {
        return ConductorModel::find($id);
    }

    public function edit(Conductor $conductor, $id) {
        $existingConductor = ConductorModel::find($id);
        if (!$existingConductor) {
            throw new \Exception("Conductor not found");
        }
        ConductorValidator::validate($conductor); // Validar antes de actualizar
        $existingConductor->update($conductor->toArray());
        return $existingConductor;
    }
}