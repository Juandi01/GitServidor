<?php
/**
 * Determina si un número es primo.
 *
 */
function esPrimo(int $n): bool
{
    if ($n <= 1) {
        return false;
    }
    for ($i = 2; $i * $i <= $n; $i++) {
        if ($n % $i == 0) {
            return false;
        }
    }
    return true;
}
echo "-1 es primo: " . (esPrimo(-1) ? 'Sí' : 'No') . "\n";
echo "0 es primo: " . (esPrimo(0) ? 'Sí' : 'No') . "\n";
echo "1 es primo: " . (esPrimo(1) ? 'Sí' : 'No') . "\n";
echo "2 es primo: " . (esPrimo(2) ? 'Sí' : 'No') . "\n";
echo "7 es primo: " . (esPrimo(7) ? 'Sí' : 'No') . "\n";
echo "10 es primo: " . (esPrimo(10) ? 'Sí' : 'No') . "\n";
