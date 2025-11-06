<?php
/**
 * Programa que suma los dígitos de un número.
 */
function sumaDigitos(int $numero): int
{
    // Convertir el número a string
    $strNumero = (string)abs($numero); // abs() devuelve el absoluto, por si es negativo
    var_dump($strNumero);
    // Separar el string en un array de caracteres (dígitos)
    $digitos = str_split($strNumero);
    var_dump($digitos);
    // Sumar el array
    return array_sum($digitos);
}

$numero = 19;
echo "La suma de dígitos de $numero es: " . sumaDigitos($numero);