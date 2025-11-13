<?php

function analizarTextoAvanzado($texto, $n = 2)
{
    // 1. Limpieza estándar (igual que el original)
    $texto = strtolower($texto);
    // Eliminamos puntuación pero dejamos espacios
    $texto = preg_replace('/[^\w\s]/', '', $texto);
    $palabras = preg_split('/\s+/', $texto, -1, PREG_SPLIT_NO_EMPTY);


    $ngramas = [];
    $cantidadPalabras = count($palabras);

    // Recorremos el array de palabras
    // El límite es ($cantidad - $n + 1) para no desbordar el array al final
    for ($i = 0; $i < $cantidadPalabras - $n + 1; $i++) {

        // Cortamos un trozo del array de longitud $n
        $secuencia = array_slice($palabras, $i, $n);

        // Unimos las palabras para formar la "frase"
        $frase = implode(' ', $secuencia);

        $ngramas[] = $frase;
    }

    // Contamos cuántas veces se repite cada frase
    $frecuenciaNgramas = array_count_values($ngramas);

    // Ordenamos de mayor a menor coincidencia
    arsort($frecuenciaNgramas);

    return [
        'total_ngramas' => count($ngramas),
        'frases_comunes' => $frecuenciaNgramas // Aquí están tus frases ordenadas
    ];
}


$textoPrueba = "El perro corre rápido. El perro corre muy rápido. El gato duerme.";

// Buscamos frases de 3 palabras (trigramas)
$resultado = analizarTextoAvanzado($textoPrueba, 3);

echo "Frases comunes encontradas:\n";
print_r($resultado['frases_comunes']);


