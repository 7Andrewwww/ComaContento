<?php
require_once("logica/Carta.php");
require_once("logica/Categoria.php");
require_once("logica/Encargado.php");
require_once("logica/Ingrediente.php");
require_once("logica/MomentoConsumo.php");
require_once("logica/NivelComplejidad.php");
require_once("logica/Plato.php");
require_once("logica/PlatoIngrediente.php");
require_once("logica/Region.php");
require_once("logica/Venta.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ComaContento</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://use.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"></script>
</head>
<body>
<?php

$paginas_permitidas = array(
    "presentacion/Inicio.php",
    "presentacion/ConsultarVentas.php",
    "presentacion/CrearCarta.php",
    "presentacion/CrearPlato.php",
    "presentacion/VentasPorMomento.php",
    "presentacion/VentasPorRegion.php",
    "presentacion/VerFotos.php",
    "presentacion/noAutorizado.php" 
);

if(!isset($_GET["pid"])) {
    include("presentacion/Inicio.php");
} else {
    $pid = base64_decode($_GET["pid"]);
    
    if(in_array($pid, $paginas_permitidas)) {
        include($pid);
    } else {
        include("presentacion/noAutorizado.php");
    }
}
?>
</body>
</html>