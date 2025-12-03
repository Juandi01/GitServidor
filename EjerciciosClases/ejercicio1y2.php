<?php
class Vehiculo {
    public $marca;
    public $modelo;
    public $anio;

    function __construct($marca, $modelo, $anio) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
    }

    function getInfo(){
        return "Informacion del vehiculo: " . $this->marca . " " . $this->modelo . " " . $this->anio;
    }
}


class Coche extends Vehiculo {
    public $numeroPuertas;

    public function __construct($marca, $modelo, $anio, $numeroPuertas) {

        parent::__construct($marca, $modelo, $anio);
        $this->numeroPuertas = $numeroPuertas;

    }

    public function getInfo(){
        return parent::getInfo() . " - Puertas: " . $this->numeroPuertas;
    }
}

// Creamos un objeto de la clase hija 'Coche'
$miCoche = new Coche("Audi", "A3", 2025, 3);
$miCarro = new Coche("Audi", "Q8", 2020, 5);

// Probamos el método sobreescrito
echo $miCoche->getInfo();
echo "\n";
echo $miCarro->getInfo();