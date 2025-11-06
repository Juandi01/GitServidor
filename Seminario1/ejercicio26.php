<?php
/**
 * Asigna valores por defecto a un array de usuario
 *
 */
function validarDatos(array $datos): array
{

    return [
        'nombre' => $datos['nombre'] ?? 'Anónimo',
        'email' => $datos['email'] ?? 'sin-email@example.com',
        'edad' => $datos['edad'] ?? 18,
        'ciudad' => $datos['ciudad'] ?? 'Desconocida',
    ];
}


$usuario = [
    'nombre' => 'Juan',
    'edad' => 25
];

print_r(validarDatos($usuario));

