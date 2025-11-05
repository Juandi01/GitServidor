<?php
/**
 *
 * Programa que determina si una palabra es un palindromo
 */

function palindromo($palabra){

    $palabra = strtolower($palabra);


    if ($palabra === strrev($palabra) && is_numeric((int)($palabra)) && (int)($palabra) == 0){
        return "La palabra introducida es un palindromo";
    }else
        return "La palabra introducida no es un palindromo";
}

$palabra = "p121p";
echo palindromo($palabra);