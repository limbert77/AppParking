<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Administrador', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('nombre',length:80);
            $table->string('apellidos',length:80);
            $table->string('email',length:30)->unique();
            $table->string('contrasena',length:30);
            $table->timestamps();
        });

        Schema::create('Conductor', function (Blueprint $table) {
            $table->id('id_con');
            $table->string('email', 30)->unique();
            $table->string('contrasena', 80);
            $table->timestamps();
        });

        Schema::create('Estacionamiento', function (Blueprint $table) {
            $table->id('id_est');
            $table->string('nombre', 80);
            $table->string('direccion', 80);
            $table->string('latitud', 80);
            $table->string('longitud', 80);
            $table->integer('capacidad_automoviles')->unsigned()->default(1);
            $table->integer('capacidad_colectivos')->unsigned()->default(1);
            $table->decimal('tarifa_automovil',total:8,places:2);
            $table->decimal('tarifa_colectivo',total:8,places:2);
            $table->enum('estado', ['activo', 'inactivo']);
            $table->timestamps();
        });
        Schema::create('Personal', function (Blueprint $table) {
            $table->id('id_per');
            $table->string('nombre',length:80);
            $table->string('apellidos',length:80);
            $table->string('email',length:30)->unique();
            $table->string('contrasena',length:30);
            $table->unsignedBigInteger('id_est');
            $table->timestamps();

            $table->foreign('id_est')->references('id_est')->on('Estacionamiento');
        });

        Schema::create('Vehiculo', function (Blueprint $table) {
            $table->id('id_vehi');
            $table->string('placa', 80);
            $table->enum('tipo_vehiculo', ['automovil', 'colectivo']);
            $table->unsignedBigInteger('id_con')->nullable();
            $table->timestamps();

            $table->foreign('id_con')->references('id_con')->on('Conductor');
        });
        
        Schema::create('Parking', function (Blueprint $table) {
            $table->id('id_parking');
            $table->dateTime('ingreso');
            $table->dateTime('salida')->nullable();
            $table->unsignedBigInteger('id_est');
            $table->unsignedBigInteger('id_vehi');
            $table->decimal('total_pagar', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('id_est')->references('id_est')->on('Estacionamiento');
            $table->foreign('id_vehi')->references('id_vehi')->on('Vehiculo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
