<?php
/**
 * Programa que calcula el máximo común divisor de dos números naturales
 *
 */
function mcd(int $a, int $b): int
{
    //uso abs otra vez para los negativos
    $a = abs($a);
    $b = abs($b);

    while ($b != 0) {
        $temporal = $b;
        //var_dump($temporal);
        $b = $a % $b;
        //var_dump($b);
        $a = $temporal;
        //var_dump($a);
    }
    return $a;
}

$num1 = 20;
$num2 = 33;

echo "El MCD de $num1 y $num2 es: " . mcd($num1, $num2);