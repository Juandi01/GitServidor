<?php
/**
 * Programa que calcula el producto de todos los elementos en un array de números.
 */
function productoArray(array $numeros): float|int
{
    // array_product es la función nativa para esto
    return array_product($numeros);
}


$arr = [2, 3, 4];
echo "El producto de [2, 3, 4] es: " . productoArray($arr);