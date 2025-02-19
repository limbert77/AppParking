<?php

namespace App\Models;
use App\Core\Administrador;

use Illuminate\Database\Eloquent\Model;

class AdministradorModel extends Model
{
    protected $table = 'Administrador';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['nombre','apellidos','email','contrasena'];
    public function ConvertToAdministrador(){
        return new Administrador($this->nombre,$this->apellidos,$this->email,$this->contrasena);
    }
}
