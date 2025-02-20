<?php 
namespace App\Core;

class Estacionamiento {
    private $id_est='';
    private $nombre='';
    private $direccion='';
    private $latitud='';
    private $longitud='';
    private $capacidad_automoviles='';
    private $capacidad_colectivos='';
    private $tarifa_automovil='';
    private $tarifa_colectivo='';
    private $estado='';

    public function __construct($nombre, $direccion, $latitud, $longitud, $capacidad_automoviles, $capacidad_colectivos, $tarifa_automovil, $tarifa_colectivo, $estado) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->capacidad_automoviles = $capacidad_automoviles;
        $this->capacidad_colectivos = $capacidad_colectivos;
        $this->tarifa_automovil = $tarifa_automovil;
        $this->tarifa_colectivo = $tarifa_colectivo;
        $this->estado = $estado;
    }

    public function show() {
        return $this->id_est . ' ' . $this->nombre . ' ' . $this->direccion . ' ' . $this->latitud . ' ' . $this->longitud . ' ' . $this->capacidad_automoviles . ' ' . $this->capacidad_colectivos . ' ' . $this->tarifa_automovil . ' ' . $this->tarifa_colectivo . ' ' . $this->estado;
    }

    public function toArray() {
        return [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'capacidad_automoviles' => $this->capacidad_automoviles,
            'capacidad_colectivos' => $this->capacidad_colectivos,
            'tarifa_automovil' => $this->tarifa_automovil,
            'tarifa_colectivo' => $this->tarifa_colectivo,
            'estado' => $this->estado
        ];
    }
}