<?php

class Libro
{
    public function generica(){
        echo "consutrctor inicializadop";
    }
    public function __construct(
        private(set) ?string $titulo = "" {
            get => strtoupper($this->titulo);
        },
        public ?string $autor = "",
    )
    {
        $this->generica();
    }



}

$libros = new Libro();
