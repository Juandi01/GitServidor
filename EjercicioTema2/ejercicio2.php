<?php
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validarNombre($nombre) {
    return strlen($nombre) >= 2 && preg_match('/^[a-zA-Z\s]+$/', $nombre);
}

function validarTelefono($telefono) {
    return preg_match('/^[0-9]{9}$/', $telefono);
}

function validarClave($clave) {
    // Al menos 8 caracteres, una mayúscula, una minúscula y un número
    return strlen($clave) >= 8 &&
        preg_match('/[A-Z]/', $clave) &&
        preg_match('/[a-z]/', $clave) &&
        preg_match('/[0-9]/', $clave);
}


$email = "juandi@efhrih.com";
$nombre = "Wan"; // <--- ERROR: Muy corto
$telefono = "2347389";
$clave = "eiufh45t78y";

try {

    // Validar Email
    if (validarEmail($email) === false) {
        throw new Exception("El email ingresado no tiene un formato válido.");
    }

    // Validar Nombre
    if (validarNombre($nombre) === false) {
        throw new Exception("El nombre no es válido (debe tener al menos 2 letras).");
    }

    // Validar Teléfono
    if (validarTelefono($telefono) === false) {
        throw new Exception("El teléfono debe contener exactamente 9 números.");
    }

    // Validar Clave
    if (validarClave($clave) === false) {
        throw new Exception("La clave es insegura. Revisa mayúsculas, minúsculas y números.");
    }

    echo "Validación completa Todos los datos son correctos.";

} catch (Exception $e) {

    // Aquí atrapamos el mensaje que escribiste en el 'throw'
    echo "Error: " . $e->getMessage();

}

validarEmail($email);
validarNombre($nombre);
validarTelefono($telefono);
validarClave($clave);
