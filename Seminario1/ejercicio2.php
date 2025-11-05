<?php
/*
 * Funcion que obtiene la sumatoria de un array
 * */

function sumaNum($numeros): float|int|string
{

    if (empty($numeros)){
        throw  new InvalidArgumentException("El array no puede estar vacio");
    }

    foreach ($numeros as $numero){
        if(!is_int($numero)){
            throw  new InvalidArgumentException("Introduce enteros, simio");
        }
    }
    if (count($numeros) <= 1) {
        return "Declara un array de más de un número";
    }

    $suma = array_sum($numeros);
    return $suma;
}

$numeros = [1,1,1,1,1];
echo sumaNum($numeros);