<?php
/**
 * Programa que compara dos arrays y devuelve un array de booleanos
 * indicando si los elementos en la misma posición son iguales.
 */
function compararArrays(array $arr1, array $arr2): array
{
    $resultado = [];
    // Usamos el tamaño del array más corto para evitar errores
    $longitud = min(count($arr1), count($arr2));

    for ($i = 0; $i < $longitud; $i++) {
        $resultado[] = ($arr1[$i] === $arr2[$i]);
    }

    return $resultado;
}


$a1 = [1, 2, 3];
$a2 = [1, 2, 4];
print_r(compararArrays($a1, $a2));