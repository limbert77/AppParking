<?php 
namespace App\Core\Services;
use App\Core\Estacionamiento;
use App\Models\EstacionamientoModel;
use App\Core\Services\EstacionamientoValidator;

class EstacionamientoService{
    
    public function add(Estacionamiento $estacionamiento) {
        EstacionamientoValidator::validate($estacionamiento); // Validar antes de insertar
        return EstacionamientoModel::create($estacionamiento->toArray());
    }

    public function getEstacionamientos() {
        return EstacionamientoModel::get();
    }

    public function findById($id) {
        return EstacionamientoModel::find($id);
    }

    public function edit(Estacionamiento $estacionamiento, $id) {
        $existingEstacionamiento = EstacionamientoModel::find($id);
        if (!$existingEstacionamiento) {
            throw new \Exception("Estacionamiento not found");
        }
        EstacionamientoValidator::validate($estacionamiento); // Validar antes de actualizar
        $existingEstacionamiento->update($estacionamiento->toArray());
        return $existingEstacionamiento;
    }

}