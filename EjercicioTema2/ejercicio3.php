<?php


// productos.php
$productos = [
    ["id" => 1, "nombre" => "Laptop", "precio" => 899.99, "stock" => 10],
    ["id" => 2, "nombre" => "Teléfono", "precio" => 499.50, "stock" => 15],
    ["id" => 3, "nombre" => "Tablet", "precio" => 349.99, "stock" => 5]
];

// Filtrar productos con precio > 400
$caros = array_filter($productos, fn($p) => $p["precio"] > 400);

// Ordenar por precio (ascendente)
usort($productos, fn($a, $b) => $a["precio"] <=> $b["precio"]);

// Calcular valor total del inventario
$valorTotal = array_reduce($productos, fn($total, $p) => $total + ($p["precio"] * $p["stock"]), 0
);



$busqueda = "lap";

// array_filter para crea un nuevo array solo con los resultados
$resultadosBusqueda = array_filter($productos, function ($producto) use ($busqueda) {
    // stripos devuelve la posición numérica si encuentra el texto, o false si no.
    // Por eso comparamos estrictamente con false (!== false).
    return stripos($producto['nombre'], $busqueda) !== false;
});

echo "Resultados para la búsqueda '$busqueda':\n";
print_r($resultadosBusqueda);

