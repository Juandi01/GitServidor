<?php
include "config/config.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $webmodular; ?></title>
    <style>
        <?php  include "./assets/css/styles.css"; ?>
    </style>
</head>



<body>



<?php include "includes/header.php"; ?>

<main>
    <?php
    //recogemos antes que nada las variables dfel get para saber uqe pAIGNA ES
    $pagina = $_GET["page"] ?? "home";
    if($pagina == "home"){
        include_once "pages/home.php";
    }else{
        include "./pages/{$pagina}.php";
    }
    ?>
</main>

<?php include "includes/footer.php"; ?>

</body>
