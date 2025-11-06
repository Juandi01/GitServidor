<?php
/**
 * Invierte una cadena de texto.
 */
function invertirCadena(string $texto): string
{
    return strrev($texto);
}

$texto = "hola";
echo "'$texto' invertido es: '" . invertirCadena($texto) . "'";

