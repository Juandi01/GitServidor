<?php
/**
 * Clasifica una nota numérica 0-10 usando una expresión 'match'.
 * Match hace lo mismo que el switch solo que la comparacion es (===) y la del switch es mas debil (==)
 */
function clasificarNota(int|float $nota): string
{
    // Redondeamos hacia abajo para manejar casos como 8.5 (que sería Notable)
    // Con ceil() se redondea hacia arriba :)
    $notaInt = (int)floor($nota);

    return match ($notaInt) {
        0, 1, 2, 3, 4 => 'Suspenso',
        5, 6 => 'Aprobado',
        7, 8 => 'Notable',
        9, 10 => 'Sobresaliente',
        default => 'Nota fuera de rango',
    };
}


$nota = 8;
echo "La calificación de $nota es: " . clasificarNota($nota) . "\n";
echo "La calificación de 4.5 es: " . clasificarNota(4.5) . "\n";