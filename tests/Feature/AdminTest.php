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

    public function test_add_park(): void {
        $newPark = new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, 5.00);
        $parkExpect = $this->listaParking->add($newPark);
        $this->assertModelExists($parkExpect);
    }

    // 2. Validar que no se pueda insertar un registro sin datos obligatorios
    public function test_add_invalid_park(): void {
        $this->expectException(ValidationException::class);
    
        // Intentar crear un parking con datos vacíos
        $newPark = new Parking('', '', '', '', '');
        $this->listaParking->add($newPark);
    
        // Capturar la excepción para validar los mensajes de error
        try {
            $this->listaParking->add($newPark);
        } catch (ValidationException $e) {
            $errors = $e->errors();
    
            // Validar que los mensajes de error sean los esperados
            $this->assertArrayHasKey('ingreso', $errors);
            $this->assertArrayHasKey('salida', $errors);
            $this->assertArrayHasKey('id_vehiculo', $errors);
            $this->assertArrayHasKey('id_espacio', $errors);
            $this->assertArrayHasKey('total_pagar', $errors);
    
            // Mensajes de error específicos (ajusta según tu lógica de validación)
            $this->assertEquals('El campo ingreso es obligatorio.', $errors['ingreso'][0]);
            $this->assertEquals('El campo salida es obligatorio.', $errors['salida'][0]);
            $this->assertEquals('El campo id_vehiculo es obligatorio.', $errors['id_vehiculo'][0]);
            $this->assertEquals('El campo id_espacio es obligatorio.', $errors['id_espacio'][0]);
            $this->assertEquals('El campo total_pagar es obligatorio.', $errors['total_pagar'][0]);
    
            throw $e; // Relanzar la excepción para que el test siga siendo válido
        }
    }

    // 3. Validar que salida no puede ser antes de ingreso
    public function test_salida_before_ingreso(): void {
    $this->expectException(ValidationException::class);

    // Intentar crear un parking con salida antes del ingreso
    $newPark = new Parking('2025-02-20 03:00:04', '2025-02-20 02:00:04', 1, 1, 5.00);
    $this->listaParking->add($newPark);

    // Capturar la excepción para validar el mensaje de error
    try {
        $this->listaParking->add($newPark);
    } catch (ValidationException $e) {
        $errors = $e->errors();

        // Validar que el mensaje de error sea el esperado
        $this->assertArrayHasKey('salida', $errors);
        $this->assertEquals('La fecha de salida no puede ser anterior a la fecha de ingreso.', $errors['salida'][0]);

        throw $e; // Relanzar la excepción para que el test siga siendo válido
    }
}

    // 4. Buscar un registro existente
    public function test_find_existing_park(): void {
        $newPark = new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, 5.00);
        $savedPark = $this->listaParking->add($newPark);
        $foundPark = $this->listaParking->list()->find($savedPark->id_parking);
        
        $this->assertNotNull($foundPark);
        $this->assertEquals($savedPark->id_parking, $foundPark->id_parking);
        $this->assertEquals($savedPark->ingreso, $foundPark->ingreso);
        $this->assertEquals($savedPark->salida, $foundPark->salida);
        $this->assertEquals($savedPark->id_vehiculo, $foundPark->id_vehiculo);
        $this->assertEquals($savedPark->id_espacio, $foundPark->id_espacio);
        $this->assertEquals($savedPark->total_pagar, $foundPark->total_pagar);
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
        $this->assertEquals($savedPark->id_parking, $editedPark->id_parking);
        $this->assertEquals($savedPark->ingreso, $editedPark->ingreso);
        $this->assertEquals($savedPark->id_vehiculo, $editedPark->id_vehiculo);
        $this->assertEquals($savedPark->id_espacio, $editedPark->id_espacio);
    }

    // 7. Intentar editar un registro que no existe
    public function test_edit_non_existent_park(): void {
        $updatedPark = new Parking('2025-02-20 02:00:04', '2025-02-20 04:00:04', 1, 1, 10.00);
        
        try {
            (new \App\Core\Services\ParkingService())->edit($updatedPark, 999);
        } catch (\Exception $e) {
            $this->assertInstanceOf(\Exception::class, $e);
            $this->assertEquals('Parking not found', $e->getMessage());
        }
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

        // Intentar crear un parking con total_pagar negativo
        $newPark = new Parking('2025-02-20 02:00:04', '2025-02-20 03:00:04', 1, 1, -5.00);
        $this->listaParking->add($newPark);

        // Capturar la excepción para validar el mensaje de error
        try {
            $this->listaParking->add($newPark);
        } catch (ValidationException $e) {
            $errors = $e->errors();

            // Validar que el mensaje de error sea el esperado
            $this->assertArrayHasKey('total_pagar', $errors);
            $this->assertEquals('El campo total_pagar debe ser mayor o igual a 0.', $errors['total_pagar'][0]);

            throw $e; // Relanzar la excepción para que el test siga siendo válido
        }
    }
}