
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
