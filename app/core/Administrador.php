<?php 
namespace App\Core;
class Administrador{
    private $nombre='';
    private $apellidos='';
    private $email='';
    private $contrasena='';
    public function __construct($nombre,$apellidos,$email,$contrasena){
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->email=$email;
        $this->contrasena=$contrasena;
    }
    public function Show(){
        return $this->nombre.' '.$this->apellidos.' '.$this->email.' '.$this->contrasena;
        // return 'Nombre: '.$this->nombre.'<br>Apellidos: '.$this->apellidos.'<br>Email: '.$this->email.'<br>Contraseña: '.$this->contrasena;
    }
    public function toArray(){
        return [
            'nombre'=>$this->nombre,
            'apellidos'=>$this->apellidos,
            'email'=>$this->email,
            'contrasena'=>$this->contrasena
        ];
    }
}