<?php


function conexion(): PDO|Exception
{
//Credenciales base datos
    $host = '127.0.0.1';
    $port = '3307';
    $db = 'biblioteca';
    $user = 'estudiante';
    $pass = 'estudiante123';
    $charset = 'utf8mb4';


    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage() . "Conexion erronea a la base de datos" . "\n";
    }
    return $pdo;
}

try {
    $pdo = conexion();
    echo "Conexion exitosa a la base de datos" . "\n";
}catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . "Conexion erronea la base de datos" . "\n";
}

