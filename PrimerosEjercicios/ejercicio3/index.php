<?php
include './config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Sitio Web Modular</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/style.css">
</head>


<body>

    <?php
    include 'includes/header.php';

    // Validar parámetro 'page'
    $pagina = $_GET['page'] ?? $paginaPorDefecto;

    if (!array_key_exists($pagina, $aPaginas)) {
        echo "<div class='container py-5'><h2>Página no encontrada</h2></div>";
    } else {
        include "pages/$pagina.php";
    }

    include 'includes/footer.php';
    ?>



</body>
</html>

