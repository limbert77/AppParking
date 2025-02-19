<?php 
namespace App\Core;
use App\Core\Administrador;
use App\Core\Services\AdministradorService;
class ListaAdministrador{
    private Array $listaAdmins;
    private AdministradorService $service;
    public function __construct() {
        $this->service = new AdministradorService();
    }
    public function add(Administrador $admin){
        return $this->service->add($admin);
    }
    public function list(){
        return $this->service->getAdmins();
    }
    public function edit(){}

}