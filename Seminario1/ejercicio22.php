<?php
/**
 * Determina si un número es perfecto.
 * Suma de sus divisores propios es igual al número.
 */
function esNumeroPerfecto(int $n): bool
{
    if ($n <= 1) {
        return false;
    }

    $sumaDivisores = 1; // Empezamos en 1 (siempre es divisor)

    // Iteramos hasta la raíz cuadrada
    for ($i = 2; $i * $i <= $n; $i++) {
        if ($n % $i == 0) {
            $sumaDivisores += $i;
            // Si no es la raíz cuadrada, añadimos su "par"
            if ($i * $i != $n) {
                $sumaDivisores += ($n / $i);
            }
        }
    }

    return $sumaDivisores === $n;
}


$num = 6; // 1 + 2 + 3 = 6
$num2 = 28; // 1 + 2 + 4 + 7 + 14 = 28
echo "$num es perfecto: " . (esNumeroPerfecto($num) ? 'Sí' : 'No') . "\n";
echo "$num2 es perfecto: " . (esNumeroPerfecto($num2) ? 'Sí' : 'No') . "\n";