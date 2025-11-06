<?php
/**
 * Programa que genera una etiqueta HTML simple a partir de una cadena Emmet
 * (solo tag, class e id).
 */
function emmetAHTML(string $emmet): string
{
    $tag = strtok($emmet, '.#');
    $classPart = strstr($emmet, '.');
    $idPart = strstr($emmet, '#');

    $clase = '';
    $id = '';

    // Extrae la clase (quitando el '.' y lo que siga después de '#')
    if ($classPart !== false) {
        $clase = strtok(substr($classPart, 1), '#');
    }

    // Extrae el ID (quitando el '#')
    if ($idPart !== false) {
        $id = substr($idPart, 1);
    }

    $atributos = '';
    if (!empty($clase)) {
        $atributos .= ' class="' . htmlspecialchars($clase) . '"';
    }
    if (!empty($id)) {
        $atributos .= ' id="' . htmlspecialchars($id) . '"';
    }

    return "<{$tag}{$atributos}></{$tag}>";
}

echo emmetAHTML("a") . "\n"; // [cite: 39]
echo emmetAHTML("div.oferta") . "\n"; // [cite: 40]
echo emmetAHTML("div.coche#VWPolo") . "\n"; // [cite: 41]
echo emmetAHTML("p#principal.importante") . "\n"; // Caso inverso