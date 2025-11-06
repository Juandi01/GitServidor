<?php
/**
 * Calcula el factorial de un número (n!).
 *
 */
function factorial(int $n): int
{
    // el factorial de 0 es 1.
    if ($n < 0) {
        throw new InvalidArgumentException("El factorial no está definido para números negativos.");
    }

    $resultado = 1;
    for ($i = 2; $i <= $n; $i++) {
        $resultado *= $i;
    }
    return $resultado;
}


$num = 5;
echo "El factorial de $num es: " . factorial($num);