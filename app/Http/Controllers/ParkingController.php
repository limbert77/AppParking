<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\ListaParking;

class ParkingController extends Controller
{
    private ListaParking $parks;
    public function __construct() {
        $this->parks = new ListaParking();
    }
    public function index(){
        $parks = $this->parks->list();
        dd($parks,$parks[0]->ConvertToParking());
    }
}
