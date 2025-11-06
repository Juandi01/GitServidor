<?php
/**
 * Programa que etermina si dos números son primos relativos .
 * Dos números son primos relativos si su MCD es 1.
 * Reutiliza la función mcd() del ejercicio 9.
 */
function sonPrimosRelativos(int $a, int $b): bool
{
    return mcd($a, $b) === 1;
}

$num1 = 20;
$num2 = 33;
$num3 = 12;
$num4 = 18;

echo "$num1 y $num2 son primos relativos: " . (sonPrimosRelativos($num1, $num2) ? 'Sí' : 'No') . "\n";
echo "$num3 y $num4 son primos relativos: " . (sonPrimosRelativos($num3, $num4) ? 'Sí' : 'No') . "\n";