<?php 
namespace App\Core;
use App\Core\Parking;
use App\Core\Services\ParkingService;
class ListaParking{
    private Array $listaParkings;
    private ParkingService $service;
    public function __construct() {
        $this->service = new ParkingService();
    }
    public function add(Parking $park){
        return $this->service->add($park);
    }
    public function list(){
        return $this->service->getParks();
    }
    public function edit(){}

}