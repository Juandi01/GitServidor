<?php
include 'includes/config.php';
include 'includes/header.php';

// Validar parámetro 'page'
$pagina = $_GET['page'] ?? $paginaPorDefecto;

if (!array_key_exists($pagina, $aPaginas)) {
    echo "<div class='container py-5'><h2>Página no encontrada</h2></div>";
} else {
    include "pages/$pagina.php";
}

include 'footer.php';
?>
