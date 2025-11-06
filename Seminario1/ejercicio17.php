<?php
/**
 * Programa que devuelve un nuevo array con solo los números pares.
 */
function filtrarPares(array $numeros): array
{
    // Usamos array_filter con una "arrow function"
    $pares = array_filter($numeros, fn($n) => $n % 2 == 0);

    // Re-indexamos el array (opcional, pero más limpio)
    return array_values($pares);
}

$arr = [1, 2, 3, 4, 5, 6];
print_r(filtrarPares($arr));