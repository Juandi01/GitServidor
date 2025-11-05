<?php
/**
 * Programa que cuenta cuantas veces aparece una letra e un texto
 */

function cuentaSubcadena($texto, $letra){

    trim($texto);
    $conteo = substr_count($texto, $letra);
    echo "La letra " . $letra . " aparece " . $conteo . " veces en el texto introducido";
}

$texto = "Hola me llamo juandi y tengo menos iq que un gorila";
cuentaSubcadena($texto, "a");


