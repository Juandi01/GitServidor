<?php

// (Guardar como 'calculadora.php' y ejecutar en terminal: 'php calculadora.php')

echo "--- Calculadora Interactiva ---\n";

// 1. Pedir números y validar
$num1 = readline("Introduce el primer número: ");
if (!is_numeric($num1)) {
    echo "Error: '$num1' no es un número válido.\n";
    exit(1);
}

$num2 = readline("Introduce el segundo número: ");
if (!is_numeric($num2)) {
    echo "Error: '$num2' no es un número válido.\n";
    exit(1);
}

// Convertir a float para los cálculos
$num1 = (float)$num1;
$num2 = (float)$num2;

// 2. Pedir operación
$op = readline("Introduce la operación (+, -, *, /): ");

// 3. Calcular y mostrar resultado
$resultado = 0;

switch ($op) {
    case '+':
        $resultado = $num1 + $num2;
        break;
    case '-':
        $resultado = $num1 - $num2;
        break;
    case '*':
        $resultado = $num1 * $num2;
        break;
    case '/':
        // 4. Manejar división por cero
        if ($num2 == 0) {
            echo "Error: No se puede dividir por cero.\n";
            exit(1);
        }
        $resultado = $num1 / $num2;
        break;
    default:
        echo "Error: Operación '$op' no reconocida.\n";
        exit(1);
}

echo "Resultado: $num1 $op $num2 = $resultado\n";

?>