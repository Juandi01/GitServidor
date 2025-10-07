<?php
require_once "config/config.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-9">
    <title><?php echo $webmodular; ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header>
    <h1><?php echo $webmodular; ?></h1>
    <nav>
        <a href="index.php">Inicio</a> |
        <a href="pages/acerca.php">Acerca</a> |
        <a href="pages/servicios.php">Servicios</a> |
        <a href="pages/contact.php">Contacto</a>
    </nav>
</header>
<main>
