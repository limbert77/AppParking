<?php 
namespace App\Core\Services;
use App\Core\Administrador;
use App\Models\AdministradorModel;

class AdministradorService{
    
    public function add(Administrador $administrador){
        return AdministradorModel::create($administrador->toArray());
    }
    public function getAdmins(){
        return AdministradorModel::get();
    }
    public function edit(Administrador $administrador){
        
    }

}