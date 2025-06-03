<?php
// Centralización de requires
require("logica/Carta.php");
require("logica/Categoria.php");
require("logica/Encargado.php");
require("logica/Ingrediente.php");
require("logica/MomentoConsumo.php");
require("logica/NivelComplejidad.php");
require("logica/Plato.php");
require("logica/PlatoIngrediente.php");
require("logica/Region.php");
require("logica/Venta.php");
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
// Definición de páginas disponibles
$paginas = array(
    "presentacion/Inicio.php",
    "presentacion/ConsultarVentas.php",
    "presentacion/CrearCarta.php",
    "presentacion/CrearPlato.php",
    "presentacion/VentasPorMomento.php",
    "presentacion/VentasPorRegion.php",
    "presentacion/VerFotos.php",
);

// Manejo de la navegación
if(!isset($_GET["pid"])) {
    include("presentacion/Inicio.php");
} else {
    $pid = $_GET["pid"];
    if(in_array($pid, $paginas)) {
        include($pid);
    } else {
        echo "<div class='alert alert-danger'>Página no encontrada</div>";
    }
}
?>
</body>
</html>