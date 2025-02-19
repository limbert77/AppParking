<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\ListaAdministrador;

class AdministradorController extends Controller
{
    private ListaAdministrador $admins;
    public function __construct() {
        $this->admins = new ListaAdministrador();
    }
    public function index(){
        $admins = $this->admins->list();
        dd($admins,$admins[0]->ConvertToAdministrador());
        //return view('admin.administrador.index',compact('admins'));
    }
}
