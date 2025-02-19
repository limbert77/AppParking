<?php 
namespace App\Core\Services;
use App\Core\Parking;
use App\Models\ParkingModel;
use App\Core\Services\ParkingValidator;

class ParkingService{
    
    public function add(Parking $parking) {
        ParkingValidator::validate($parking); // Validar antes de insertar
        return ParkingModel::create($parking->toArray());
    }

    public function getParks() {
        return ParkingModel::get();
    }

    public function findById($id) {
        return ParkingModel::find($id);
    }

    public function edit(Parking $parking, $id) {
        $existingPark = ParkingModel::find($id);
        if (!$existingPark) {
            throw new \Exception("Parking not found");
        }
        ParkingValidator::validate($parking); // Validar antes de actualizar
        $existingPark->update($parking->toArray());
        return $existingPark;
    }

}