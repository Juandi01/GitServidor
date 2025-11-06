<?php
/**
 * Determina si un número es un número Armstrong.
 * Suma de sus dígitos elevados a la potencia del n° de dígitos
 */
function esNumeroArmstrong(int $n): bool
{
    if ($n < 0) return false;

    $strNum = (string)$n;
    // strlen para usarlo posetriormente como potencia
    $potencia = strlen($strNum);
    $suma = 0;
    //str_split para dividir el entero, convertido a string anteriormente, en un array
    $digitos = str_split($strNum);

    foreach ($digitos as $digito) {
        //convierto el string de array de enteros y uso pow para elevarlo a la potencia obtenida con strlen
        $suma += pow((int)$digito, $potencia);
    }

    return $suma === $n;
}


$num = 153; // 1³ + 5³ + 3³ = 1 + 125 + 27 = 153
echo "$num es Armstrong: " . (esNumeroArmstrong($num) ? 'Sí' : 'No') . "\n";