<?php
/**
 * Programa que imprime un mosaico numérico hasta n.
 *
 */
function imprimirMosaico(int $n): void
{
    for ($i = 1; $i <= $n; $i++) {
        // Repite el string $i, $i veces.
        echo str_repeat((string)$i, $i);
        echo "\n";
    }
}

imprimirMosaico(6);