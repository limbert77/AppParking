<?php 
namespace App\Core;

use App\Core\Conductor;
use App\Core\Services\ConductorService;

class ListaConductor {
    private array $listaConductores;
    private ConductorService $service;

    public function __construct() {
        $this->service = new ConductorService();
    }

    public function add(Conductor $conductor) {
        return $this->service->add($conductor);
    }

    public function list() {
        return $this->service->getConductores();
    }

    public function edit(Conductor $conductor, $email) {
        return $this->service->edit($conductor, $email);
    }
}