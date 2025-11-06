<?php
/**
 * Accede de forma segura a propiedades anidadas usando el
 * operador nullsafe (?->).
 *
 * Nota: ?-> SOLO funciona con OBJETOS.
 * El ejercicio pide simular con stdClass. [cite: 105]
 */
function obtenerCodigoPostal(object $usuario): string
{
    // [cite: 117]
    // Intentamos acceder a $usuario->direccion->codigoPostal
    // Si 'direccion' es null, ?-> detiene la cadena y devuelve null.
    // El '??' final maneja el caso de que el resultado sea null.
    return $usuario?->direccion?->codigoPostal ?? 'Código Postal no disponible';
}

// 1. Creamos el objeto stdClass (simulando desde un array) [cite: 107-116]
$usuarioArray = [
    'nombre' => 'Ana',
    'direccion' => [
        'calle' => 'Gran Vía',
        'ciudad' => 'Madrid'
    ]
];
// Convertimos el array a objeto (necesario para ?->)
$usuarioObj = json_decode(json_encode($usuarioArray));

// 2. Creamos un usuario sin dirección
$usuarioSinDireccion = (object)['nombre' => 'Pedro'];


echo "CP de Ana: " . obtenerCodigoPostal($usuarioObj) . "\n";
echo "CP de Pedro: " . obtenerCodigoPostal($usuarioSinDireccion) . "\n";

/**
 * He usado ia descarado porque no sabia para que servia el nullsafe y al parecer solo funciona con objetos,
 * para acceder a una propiedad o metodo de un objeto.
 *
 */