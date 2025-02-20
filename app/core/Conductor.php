<?php 
namespace App\Core;

class Conductor {
    private $id_con;
    private $email = '';
    private $contrasena = '';

    public function __construct($email,$contrasena){
        $this->email = $email;
        $this->contrasena = $contrasena;
    }

    public function show() {
        return $this->email . ' ' . $this->contrasena;
    }

    public function toArray() {
        return [
            'email' => $this->email,
            'contrasena' => $this->contrasena
        ];
    }
}