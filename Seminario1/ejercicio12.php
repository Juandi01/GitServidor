<?php
/**
 * Programa que etermina si un número dado es capicúa.
 */
function esCapicua(int $numero): bool
{
    $numeroStr = (string)abs($numero);
    return $numeroStr === strrev($numeroStr);
}

$num1 = 1331;
$num2 = 12345;

echo "$num1 es capicúa: " . (esCapicua($num1) ? 'Sí' : 'No') . "\n";
echo "$num2 es capicúa: " . (esCapicua($num2) ? 'Sí' : 'No') . "\n";