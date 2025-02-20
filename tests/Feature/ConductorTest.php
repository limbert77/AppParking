<?php

namespace Tests\Feature;
use App\Core\ListaAdministrador;
use App\Core\Administrador;
use App\Core\Conductor;
use App\Core\ListaConductor;
use App\Core\ListaParking;
use App\Core\Parking;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConductorTest extends TestCase
{
    private ListaConductor $listaConductor;
    protected function setUp(): void {
        parent::setUp();
        $this->listaConductor = new ListaConductor();
    }
    
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_add_cond(): void {
        $newCond = new Conductor('limbert@gmail.com', '1234');
        $condExpect = $this->listaConductor->add($newCond);
        $this->assertModelExists($condExpect);
    }
    // 2. Validar que no se pueda insertar un registro sin datos obligatorios
    public function test_add_invalid_cond(): void {
        $this->expectException(ValidationException::class);
        $newCond = new Conductor('', '');
        $this->listaConductor->add($newCond);
    }
    
}
