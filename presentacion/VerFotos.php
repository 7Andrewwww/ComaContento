<?php
require_once("logica/Plato.php");
require_once("logica/NivelComplejidad.php");
require_once("logica/Categoria.php");
require_once("logica/MomentoConsumo.php");
require_once("logica/Region.php");
require_once("logica/Encargado.php");

// Obtener todos los platos con sus fotos
$platos = Plato::consultarTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Fotos de Platos - ComaContento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        .gallery-container {
            padding: 20px 0;
        }
        .gallery-title {
            text-align: center;
            margin-bottom: 30px;
            color: #003893;
            font-weight: bold;
            text-transform: uppercase;
        }
        .gallery-card {
            transition: all 0.3s ease;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            height: 100%;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .gallery-img-container {
            height: 200px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-card-body {
            padding: 15px;
            background: #f8f9fa;
        }
        .plato-name {
            font-weight: bold;
            color: #003893;
            margin-bottom: 5px;
        }
        .plato-precio {
            font-weight: bold;
            color: #28a745;
        }
        .plato-desc {
            color: #6c757d;
            font-size: 0.9em;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 60px;
        }
        .btn-ver-detalle {
            background: #fcd116;
            border: none;
            color: #003893;
            font-weight: bold;
            width: 100%;
        }
        .btn-ver-detalle:hover {
            background: #003893;
            color: #fcd116;
        }
        .no-photo {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            flex-direction: column;
        }
        .no-photo i {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        .badge-info {
            background-color: #17a2b8;
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<?php include("presentacion/fondo.php"); ?>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="?pid=<?= base64_encode('presentacion/Inicio.php') ?>">Colombiano, Coma Contento</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="?pid=<?= base64_encode('presentacion/Inicio.php#about') ?>">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="?pid=<?= base64_encode('presentacion/Inicio.php#modulos') ?>">Módulos</a></li>
          <li class="nav-item"><a class="nav-link" href="?pid=<?= base64_encode('presentacion/Inicio.php#contacto') ?>">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>
<div class="container gallery-container">
    <h1 class="gallery-title">Nuestros Platos</h1>
    
    <div class="row">
        <?php foreach($platos as $plato): 
            $plato->consultar(); // Asegurarnos de cargar todos los datos del plato
        ?>
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card gallery-card">
                <div class="gallery-img-container">
                    <?php if($plato->getFoto() && file_exists($plato->getFoto())): ?>
                        <a href="<?= htmlspecialchars($plato->getFoto()) ?>" data-lightbox="platos" data-title="<?= htmlspecialchars($plato->getNombre()) ?>">
                            <img src="<?= htmlspecialchars($plato->getFoto()) ?>" class="gallery-img" alt="<?= htmlspecialchars($plato->getNombre()) ?>">
                        </a>
                    <?php else: ?>
                        <div class="no-photo">
                            <i class="bi bi-image"></i>
                            <span>Imagen no disponible</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="card-body gallery-card-body">
                    <h5 class="plato-name"><?= htmlspecialchars($plato->getNombre()) ?></h5>
                    <p class="plato-precio">$<?= number_format($plato->getPrecioBase(), 0, ',', '.') ?></p>
                    <p class="plato-desc"><?= htmlspecialchars($plato->getDescripcion()) ?></p>
                    
                    <div class="mb-2">
                        <span class="badge badge-info"><?= htmlspecialchars($plato->getCategoria()->getNombre()) ?></span>
                        <span class="badge badge-info"><?= htmlspecialchars($plato->getRegion()->getNombre()) ?></span>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Botón flotante para volver al inicio -->
<a href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>" class="btn btn-warning btn-flotante">
    <i class="fas fa-home"></i>
</a>

<!-- Scripts necesarios -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<!-- Estilo para el botón flotante -->
<style>
    .btn-flotante {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 1000;
        text-decoration: none;
        color: #212529;
        transition: all 0.3s ease;
    }
    
    .btn-flotante:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        color: #212529;
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<!-- Font Awesome para el ícono de casa -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>