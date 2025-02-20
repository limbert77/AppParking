<?php

namespace App\Models;

use App\Core\Conductor;
use Illuminate\Database\Eloquent\Model;

class ConductorModel extends Model
{
    protected $table = 'Conductor';
    protected $primaryKey = 'id_con';
    protected $fillable = ['email', 'contrasena'];

    public function convertToConductor()
    {
        return new Conductor($this->email, $this->contrasena);
    }
}
