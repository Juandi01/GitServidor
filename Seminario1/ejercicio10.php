<?php
/**
 * Programa que alcula el término n de la sucesión de Fibonacci.
 * 0, 1, 1, 2, 3, 5, 8...
 * (El término 0 es 0, el 1 es 1, el 2 es 1, etc.)
 */
function fibonacci(int $n): int
{
    if ($n < 0) {
        throw new InvalidArgumentException("N no puede ser negativo.");
    }
    if ($n === 0) {
        return 0;
    }

    $a = 0;
    $b = 1;

    for ($i = 2; $i <= $n; $i++) {
        $siguiente = $a + $b;
        $a = $b;
        $b = $siguiente;
    }

    return $b;
}

$n = 8;
echo "El término $n de Fibonacci es: " . fibonacci($n);