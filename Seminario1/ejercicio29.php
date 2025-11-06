<?php

/**
 * Convierte entre Celsius, Fahrenheit y Kelvin.
 *
 */
function convertirTemperatura(float $valor, string $unidadDesde, string $unidadA, bool $debug = false): float
{
    if ($debug) {
        // Uso de constantes mágicas [cite: 127]
        echo "DEBUG (Línea " . __LINE__ . "): Iniciando función '" . __FUNCTION__ . "'...\n";
    }

    $unidadDesde = strtolower($unidadDesde);
    $unidadA = strtolower($unidadA);

    // 1. Convertir todo a Celsius (unidad base)
    $valorEnCelsius = match ($unidadDesde) {
        'celsius' => $valor,
        'fahrenheit' => ($valor - 32) * 5 / 9,
        'kelvin' => $valor - 273.15,
        default => throw new InvalidArgumentException("Unidad 'desde' desconocida: $unidadDesde")
    };

    if ($debug) {
        echo "DEBUG (Línea " . __LINE__ . "): Valor base en Celsius: $valorEnCelsius\n";
    }

    // 2. Convertir de Celsius a la unidad deseada
    $resultado = match ($unidadA) {
        'celsius' => $valorEnCelsius,
        'fahrenheit' => ($valorEnCelsius * 9 / 5) + 32,
        'kelvin' => $valorEnCelsius + 273.15,
        default => throw new InvalidArgumentException("Unidad 'a' desconocida: $unidadA")
    };

    return $resultado;
}

// --- Uso ---
$tempC = 25;
$tempF = convertirTemperatura($tempC, 'celsius', 'fahrenheit'); // [cite: 134]
echo "$tempC C son $tempF F\n";

// Con depuración
echo "--- Con Debug ---\n";
$tempK = 300;
$tempC_debug = convertirTemperatura($tempK, 'kelvin', 'celsius', true);
echo "$tempK K son $tempC_debug C\n";

//asistido completamente con la IA :)