<?php
/**
 *
 * Programa que capitaliza palabras
 * Pone en mayuscula cada letra inicial de cada palabra del texto
 *
 */

function capitalizarPalabras(string $texto): string
{
    // ucwords hace exactamente esto
    return ucwords(strtolower($texto));
}

$texto = "hola mundo";
$texto2 = "sopa de macaco sopa de vinicius";
echo capitalizarPalabras($texto);
echo capitalizarPalabras($texto2);