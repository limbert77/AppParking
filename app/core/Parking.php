<?php 
namespace App\Core;
class Parking{
    private $ingreso='';
    private $salida='';
    private $id_est='';
    private $id_vehi='';
    private $total_pagar='';
    public function __construct($ingreso,$salida,$id_est,$id_vehi,$total_pagar){
        $this->ingreso=$ingreso;
        $this->salida=$salida;
        $this->id_est=$id_est;
        $this->id_vehi=$id_vehi;
        $this->total_pagar=$total_pagar;
    }
    public function Show(){
        return $this->ingreso.' '.$this->salida.' '.$this->id_est.' '.$this->id_vehi.' '.$this->total_pagar;
    }
    public function toArray(){
        return [
            'ingreso'=>$this->ingreso,
            'salida'=>$this->salida,
            'id_est'=>$this->id_est,
            'id_vehi'=>$this->id_vehi,
            'total_pagar'=>$this->total_pagar
        ];
    }
}