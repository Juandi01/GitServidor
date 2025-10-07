<?php
$nombre ="Juandi Delgado Morente";
$edad = 23;
$ciudad = "Córdoba";
$fechaHora = date("d/m/Y H:i:s");

?>
<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <title>Mi primera pagina php</title>
<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="contenedor">
    <h1>¡Bienvenido a mi página personal!</h1>
    <div class="info">
        <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
        <p><strong>Edad:</strong> <?php echo $edad; ?> años</p>
        <p><strong>Ciudad:</strong> <?php echo $ciudad; ?></p>
    </div>
    <div class="fecha">
        Fecha y hora actual: <?php echo $fechaHora; ?>
    </div>
</div>
</body>
</html>
