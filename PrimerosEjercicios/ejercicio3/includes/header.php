<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sitio Web Modular</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Mi Sitio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <?php
          $paginaActual = $_GET['page'] ?? $paginaPorDefecto;
          foreach ($aPaginas as $key => $nombre) {
              $activo = ($paginaActual == $key) ? 'active' : '';
              echo "<li class='nav-item'><a class='nav-link $activo' href='index.php?page=$key'>$nombre</a></li>";
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>
