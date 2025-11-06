<?php
/**
 * Elimina todas las vocales de una cadena.
 */
function eliminarVocales(string $texto): string
{

    // el modificador i ignora que sean mayusculs o minusculas, es un modificador case-insensitive
    return preg_replace('/[aeiou]/i', '', $texto);
}

$texto = "Hola Mundo Urdangarin zApATeRO PedrO";
echo "'$texto' sin vocales es: '" . eliminarVocales($texto) . "'";
