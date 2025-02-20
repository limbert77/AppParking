<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstacionamientoModel extends Model
{
    protected $table = 'Estacionamiento';
    protected $primaryKey = 'id_est';
    protected $fillable = [
        'nombre',
        'direccion',
        'latitud',
        'longitud',
        'capacidad_automoviles',
        'capacidad_colectivos',
        'tarifa_automovil',
        'tarifa_colectivo',
        'estado'
    ];

    public function ConvertToParking()
    {
        return new Parking(
            $this->nombre,
            $this->direccion,
            $this->latitud,
            $this->longitud,
            $this->capacidad_automoviles,
            $this->capacidad_colectivos,
            $this->tarifa_automovil,
            $this->tarifa_colectivo,
            $this->estado
        );
    }
}
