<?php 
namespace App\Core;
use App\Core\Estacionamiento;
use App\Core\Services\EstacionamientoService;

class ListaEstacionamiento {
    private Array $listaEstacionamientos;
    private EstacionamientoService $service;

    public function __construct() {
        $this->service = new EstacionamientoService();
    }

    public function add(Estacionamiento $estacionamiento) {
        return $this->service->add($estacionamiento);
    }

    public function list() {
        return $this->service->getEstacionamientos();
    }

    public function edit() {}
}