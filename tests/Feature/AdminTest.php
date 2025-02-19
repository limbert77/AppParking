<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Core\ListaAdministrador;
use App\Core\Administrador;
use App\Core\ListaParking;
use App\Core\Parking;
use Illuminate\Validation\ValidationException;

class AdminTest extends TestCase
{
    private ListaParking $listaParking;

    protected function setUp(): void {
        parent::setUp();
        $this->listaParking = new ListaParking();
    }
    
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    // public function test_add_admin(): void
    // {
    //     $listaAdmin = new ListaAdministrador();
    //     $newAdmin = new Administrador('Juan','Perez','a@sssss.v','123664');
    //     $adminExpect = $listaAdmin->add($newAdmin);
    //     //comparativa:
    //     $this->assertModelExists($adminExpect);
    // }
    public function test_add_park(): void {
        $newPark = new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, 5.00);
        $parkExpect = $this->listaParking->add($newPark);
        $this->assertModelExists($parkExpect);
    }

    // 2. Validar que no se pueda insertar un registro sin datos obligatorios
    public function test_add_invalid_park(): void {
        $this->expectException(ValidationException::class);
        $newPark = new Parking('', '', '', '', '');
        $this->listaParking->add($newPark);
    }

    // 3. Validar que salida no puede ser antes de ingreso
    public function test_salida_before_ingreso(): void {
        $this->expectException(ValidationException::class);
        $newPark = new Parking('2025-02-20 03:00:04', '2025-02-20 02:00:04', 1, 1, 5.00);
        $this->listaParking->add($newPark);
    }

    // 4. Buscar un registro existente
    public function test_find_existing_park(): void {
        $newPark = new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, 5.00);
        $savedPark = $this->listaParking->add($newPark);
        $foundPark = $this->listaParking->list()->find($savedPark->id_parking);
        $this->assertNotNull($foundPark);
    }

    // 5. Buscar un registro que no existe
    public function test_find_non_existent_park(): void {
        $foundPark = $this->listaParking->list()->find(999);
        $this->assertNull($foundPark);
    }

    // 6. Editar un registro existente
    public function test_edit_existing_park(): void {
        $newPark = new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, 5.00);
        $savedPark = $this->listaParking->add($newPark);

        $updatedPark = new Parking('2025-02-20 02:00:04', '2025-02-20 04:00:04', 1, 1, 10.00);
        $editedPark = (new \App\Core\Services\ParkingService())->edit($updatedPark, $savedPark->id_parking);

        $this->assertEquals('2025-02-20 04:00:04', $editedPark->salida);
        $this->assertEquals(10.00, $editedPark->total_pagar);
    }

    // 7. Intentar editar un registro que no existe
    public function test_edit_non_existent_park(): void {
        $this->expectException(\Exception::class);
        $updatedPark = new Parking('2025-02-20 02:00:04', '2025-02-20 04:00:04', 1, 1, 10.00);
        (new \App\Core\Services\ParkingService())->edit($updatedPark, 999);
    }

    // 8. Listar todos los registros
    public function test_list_all_parks(): void
    {
        // Contar cuántos registros hay antes de la prueba
        $initialCount = count($this->listaParking->list());

        // Agregar dos nuevos registros
        $this->listaParking->add(new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, 5.00));
        $this->listaParking->add(new Parking('2025-02-20 04:00:04', '2025-02-20 05:00:04', 1, 2, 10.00));

        // Obtener la lista de registros nuevamente
        $parks = $this->listaParking->list();

        // Validar que la diferencia entre el total final y el inicial sea 2
        $this->assertEquals($initialCount + 2, count($parks));
    }


    // 9. Validar que total_pagar no sea negativo
    public function test_total_pagar_not_negative(): void {
        $this->expectException(ValidationException::class);
        $newPark = new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, -5.00);
        $this->listaParking->add($newPark);
    }

}
