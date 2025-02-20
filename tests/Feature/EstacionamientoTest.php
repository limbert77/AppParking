<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Core\ListaEstacionamiento;
use App\Core\Estacionamiento;
use Illuminate\Validation\ValidationException;

class EstacionamientoTest extends TestCase
{
    private ListaEstacionamiento $listaEstacionamiento;

    protected function setUp(): void {
        parent::setUp();
        $this->listaEstacionamiento = new ListaEstacionamiento();
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    //1. Validar que se pueda insertar un registro con datos obligatorios
    public function test_add_est(): void {
        $newEst = new Estacionamiento('UPDS', 'av Union', '123456', '654321', '10', 5, 5, 10, 'activo');
        $estExpect = $this->listaEstacionamiento->add($newEst);
        $this->assertModelExists($estExpect);
    }
    //2. Validar que no se pueda insertar un registro sin datos obligatorios
    public function test_add_invalid_est(): void {
        $this->expectException(ValidationException::class);
    
        // Intentar crear un estacionamiento con datos vacíos
        $newEst = new Estacionamiento('', '', '', '', '', '', '', '', '');
        $this->listaEstacionamiento->add($newEst);
    
        // Capturar la excepción para validar los mensajes de error
        try {
            $this->listaEstacionamiento->add($newEst);
        } catch (ValidationException $e) {
            $errors = $e->errors();
    
            // Validar que los mensajes de error sean los esperados
            $this->assertArrayHasKey('nombre', $errors);
            $this->assertArrayHasKey('direccion', $errors);
            $this->assertArrayHasKey('latitud', $errors);
            $this->assertArrayHasKey('longitud', $errors);
            $this->assertArrayHasKey('capacidad_automoviles', $errors);
            $this->assertArrayHasKey('capacidad_colectivos', $errors);
            $this->assertArrayHasKey('tarifa_automovil', $errors);
            $this->assertArrayHasKey('tarifa_colectivo', $errors);
            $this->assertArrayHasKey('estado', $errors);
    
            // Mensajes de error específicos (ajusta según tu lógica de validación)
            $this->assertEquals('El campo nombre es obligatorio.', $errors['nombre'][0]);
            $this->assertEquals('El campo direccion es obligatorio.', $errors['direccion'][0]);
            $this->assertEquals('El campo latitud es obligatorio.', $errors['latitud'][0]);
            $this->assertEquals('El campo longitud es obligatorio.', $errors['longitud'][0]);
            $this->assertEquals('El campo capacidad automoviles es obligatorio.', $errors['capacidad_automoviles'][0]);
            $this->assertEquals('El campo capacidad colectivos es obligatorio.', $errors['capacidad_colectivos'][0]);
            $this->assertEquals('El campo tarifa automovil es obligatorio.', $errors['tarifa_automovil'][0]);
            $this->assertEquals('El campo tarifa colectivo es obligatorio.', $errors['tarifa_colectivo'][0]);
            $this->assertEquals('El campo estado es obligatorio.', $errors['estado'][0]);
    
            throw $e; // Relanzar la excepción para que el test siga siendo válido
        }
    }
    //3. Validar que cantidad de espacios no puede ser menor a 0
    public function test_cantidad_espacios_mayor_cero(): void {
        $this->expectException(ValidationException::class);
    
        // Intentar crear un estacionamiento con cantidad de espacios menor a 0
        $newEst = new Estacionamiento('UPDS', 'av Union', '123456', '654321', '-1', 5, 5, 10, 'activo');
        $this->listaEstacionamiento->add($newEst);
    
        // Capturar la excepción para validar los mensajes de error
        try {
            $this->listaEstacionamiento->add($newEst);
        } catch (ValidationException $e) {
            $errors = $e->errors();
    
            // Validar que los mensajes de error sean los esperados
            $this->assertArrayHasKey('cantidad_espacios', $errors);
    
            // Mensajes de error específicos (ajusta según tu lógica de validación)
            $this->assertEquals('El campo cantidad espacios debe ser mayor a 0.', $errors['cantidad_espacios'][0]);
    
            throw $e; // Relanzar la excepción para que el test siga siendo válido
        }
    }
}
