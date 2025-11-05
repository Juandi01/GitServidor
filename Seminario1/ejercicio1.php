<?php
/* @author Juandi
 * Fucnion que obtiene el valor maximo de un array de numeros
 * */

function numeroMax(array $numeros){
    if (empty($numeros)){
        throw  new InvalidArgumentException("El array no puede estar vacio");
    }

    foreach ($numeros as $numero){
        if(!is_int($numero)){
            throw  new InvalidArgumentException("Introduce enteros, simio");
        }
    }
    return max($numeros);
}

$numeros = [21,231,213,123,21,312,32,33,46,568789];
echo "El numero mas alto del array es " . numeroMax($numeros);