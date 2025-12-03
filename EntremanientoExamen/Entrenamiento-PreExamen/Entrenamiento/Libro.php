<?php
class Libro
{
    public string $titulo{
        set => trim($this->titulo);
    }
    private(set) int $id;
    private(set) int $autorId;
    private(set) int $generoId;
    private(set) string $isbn;

    public int $ejemplares{
        set{
            if ($value < 0){
                throw new Exception("Los ejemplares no pueden ser menos de 0");
            }
            $this->ejemplares = $value;
        }
    }
    public int $disponibles{
        set {
            if ($value < 0) {
                throw new Exception("Los disponibles no pueden ser menos de 0");
            }
            //if isset?¿?¿
            if ($value > $this->ejemplares) {
                throw new Exception("No puede haber mas ejemplares de los disponibles");
            }
            $this->disponibles = $value;
        }
    }

    public function __construct(string $titulo, int $id, int $autorId, int $generoId, string $isbn, int $ejemplares, int $disponibles){
        $this->titulo = $titulo;
        $this->id = $id;
        $this->autorId = $autorId;
        $this->generoId = $generoId;
        $this->isbn = $isbn;
        $this->ejemplares = $ejemplares;
        $this->disponibles = $disponibles;

    }

    //Metodo tradicional
    /*function estaDisponible(): bool {
        // Esto evalúa la condición: si es mayor a 0 devuelve true, si no, false.
        return $this->disponibles > 0;
    }*/

    //Metodo moderno ralladon property hook
    //Propiedad computada
    public bool $estaDisponible {
        get => $this->disponibles > 0;
    }

    public function prestar() : bool{
        if ($this->estaDisponible) {
            $this->disponibles--;
        }return true;
    }


    public function devolver(): bool{
        $this->disponibles++;
        return true;
    }

    public function toArray() : array{
        return [
            "titulo" => $this->titulo,
            "id" => $this->id,
            "autorId" => $this->autorId,
            "generoId" => $this->generoId,
            "isbn" => $this->isbn,
            "ejemplares" => $this->ejemplares,
            "disponibles" => $this->disponibles
        ];
    }

    public static function buscarpodID(int $id) : ?Libro{
        if ()
    }

}

$libro = new Libro("PHP para Expertos", 1,10, 5, "ISBN-001", 5, 1);

if($libro->estaDisponible){
    echo "Disposnible suloco";
}else{
    echo "VACIO";
}
$libro->prestar();
$libro->prestar();
$libro->prestar();
$libro->prestar();
$libro->prestar();
$libro->prestar();


if($libro->estaDisponible){
    echo "Disposnible suloco";
}else{
    echo "VACIO";
}


//para sacar pro consola el array
$datoslibro = $libro->toArray();
print_r($datoslibro);
// o tambien se puede con el JsonSerializable
echo json_encode($datoslibro);

