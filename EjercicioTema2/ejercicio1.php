<?php
function calcular($num1, $num2, $operacion){

    $op = strtolower(trim($operacion));

    if ($operacion === 'raiz' && $num1 < 0) {
        throw new ValueError("No se puede calcular la raíz cuadrada de un número negativo.");
    }
    return match($op){
        'suma' => $num1 + $num2,
        'resta' => $num1 - $num2,
        'multiplicacion' => $num1 * $num2,
        'division' => $num2 != 0 ? $num1 / $num2 : "Error division por cero",
        'raiz' => sqrt($num1),
        'modulo' => $num2 != 0 ? $num1 % $num2 : "Error division por cero",
        default => throw new InvalidArgumentException("La operación '$operacion' no es válida.
         Usa: suma, resta, multiplicacion, division, modulo o raiz")
    };
}

try {
    $resultado = calcular(10, 0, 'multiplicacion');
    echo $resultado;
} catch (DivisionByZeroError $e) {
    // 1. Captura errores matemáticos de división
    echo "Error Matemático: " . $e->getMessage();

} catch (InvalidArgumentException $e) {
    // 2. Captura cuando escribes mal la operación
    echo "Error de Operación: " . $e->getMessage();

} catch (ValueError $e) {
    // 3. Captura errores de valor (ej: raiz de -5)
    echo "Error de Valor: " . $e->getMessage();

} catch (TypeError $e) {
    // 4. Captura si pasas texto en vez de números (ej: calcular("hola", 5, 'suma'))
    echo "Error de Tipo: Los argumentos deben ser números.";
}

