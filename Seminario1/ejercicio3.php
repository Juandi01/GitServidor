<?php
/*
 * Funcion que pasa de millas a kilometros
 * */

function conversor($numero){
    if ($numero <= 0){
        return "Convierte una cantidad mayor que 0";
    }
    $CONV = 1.60934;
    $millas = $numero * $CONV;

    return $numero . " kilometros son ". $millas . " millas";
}

$kilometros = 10;
echo conversor($kilometros);