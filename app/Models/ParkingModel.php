<?php

namespace App\Models;
use App\Core\Parking;

use Illuminate\Database\Eloquent\Model;

class ParkingModel extends Model
{
    protected $table = 'Parking';
    protected $primaryKey = 'id_parking';
    protected $fillable = ['ingreso','salida','id_est','id_vehi','total_pagar'];

    public function ConvertToParking()
    {
        return new Parking($this->ingreso,$this->salida,$this->id_est,$this->id_vehi,$this->total_pagar);
    }
    
}
