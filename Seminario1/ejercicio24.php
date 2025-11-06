<?php
// Defino las constantes
define('DESCUENTO_ESTUDIANTE', 0.15); // 15%
define('DESCUENTO_JUBILADO', 0.20); // 20%
define('DESCUENTO_VIP', 0.25); // 25%

/**
 * Calcula el precio final aplicando un descuento según el tipo de cliente.
 */
function calcularPrecioFinal(float $precioBase, string $tipoCliente): float
{
    $tipoCliente = strtolower($tipoCliente);
    $descuento = 0.0;

    switch ($tipoCliente) {
        case 'estudiante':
            $descuento = DESCUENTO_ESTUDIANTE;
            break;
        case 'jubilado':
            $descuento = DESCUENTO_JUBILADO;
            break;
        case 'vip':
            $descuento = DESCUENTO_VIP;
            break;
    }

    $precioFinal = $precioBase * (1 - $descuento);
    return $precioFinal;
}


$precio = 100;
$cliente = "estudiante"; //
echo "Precio final para $cliente sobre $precio: " . calcularPrecioFinal($precio, $cliente);