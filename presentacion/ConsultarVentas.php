<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/VentasDAO.php");
require_once("logica/Venta.php");
require_once("logica/Plato.php");

// Obtener años disponibles
$anios = Venta::consultarAniosDisponibles();

// Procesar filtros
$añoFiltro = isset($_GET['año']) ? intval($_GET['año']) : null;
$mesFiltro = isset($_GET['mes']) ? intval($_GET['mes']) : null;

// Consultar ventas por mes
$ventasPorMes = Venta::consultarVentasPorMes($añoFiltro);

// Consultar ventas por plato si hay filtros de mes y año
if ($mesFiltro && $añoFiltro) {
    $ventasPorPlato = Venta::consultarVentasPorPlato($mesFiltro, $añoFiltro);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Ventas | Colombiano, Coma Contento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('../imagenes/fondo.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      position: relative;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.7);
      z-index: -1;
    }
    
    .navbar {
      background: linear-gradient(to right, #fcd116, #003893, #ce1126);
      border-bottom-left-radius: 1rem;
      border-bottom-right-radius: 1rem;
    }
    
    .navbar-brand, .nav-link {
      color: white !important;
      font-weight: 600;
    }
    
    .hero {
      background-size: cover;
      background-position: center;
      color: black;
      padding: 4rem 2rem;
      text-align: center;
      background-blend-mode: overlay;
      background-color: rgba(0, 0, 0, 0);
      border-radius: 0 0 2rem 2rem;
    }
    
    .card {
      border: none;
      border-radius: 1.5rem;
      overflow: hidden;
      background-color: #fff;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    
    .card-header {
      background: linear-gradient(to right, #fcd116, #003893);
      color: white;
      font-weight: bold;
      border-radius: 1.5rem 1.5rem 0 0 !important;
    }
    
    .btn-primary {
      background-color: #003893;
      border-color: #003893;
      border-radius: 50px;
    }
    
    .btn-primary:hover {
      background-color: #002366;
      border-color: #002366;
    }
    
    .btn-warning {
      background-color: #fcd116;
      border-color: #fcd116;
      color: #333;
      border-radius: 50px;
    }
    
    .btn-warning:hover {
      background-color: #e6b800;
      border-color: #e6b800;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }
    
    th {
      background-color: #003893;
      color: white;
      padding: 12px;
      text-align: left;
    }
    
    td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }
    
    tr:nth-child(even) {
      background-color: rgba(0, 56, 147, 0.05);
    }
    
    tr:hover {
      background-color: rgba(252, 209, 22, 0.1);
    }
    
    .filtro-container {
      background-color: white;
      padding: 1.5rem;
      border-radius: 1rem;
      margin-bottom: 2rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    footer {
      background-color: #003893;
      color: white;
      text-align: center;
      padding: 1.5rem;
      border-top-left-radius: 2rem;
      border-top-right-radius: 2rem;
      margin-top: 3rem;
    }
    
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
    }
  </style>
</head>
<body>
<?php
include("presentacion/fondo.php");
?>
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="?pid=<?= base64_encode('presentacion/Inicio.php') ?>">Colombiano, Coma Contento</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>#about">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>#modulos">Módulos</a></li>
          <li class="nav-item"><a class="nav-link" href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>#contacto">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero">
    <div class="container">
      <h1 class="display-4 fw-bold">Estadísticas de Ventas</h1>
      <p class="lead">Analiza el desempeño de nuestros platos</p>
    </div>
  </section>

  <div class="container py-5">
    <div class="filtro-container">
      <form method="get" action="?pid=<?= base64_encode('presentacion/ConsultarVentas.php') ?>" class="row g-3 align-items-center">
        <input type="hidden" name="pid" value="<?= base64_encode('presentacion/ConsultarVentas.php') ?>">
        <div class="col-md-4">
          <label for="año" class="form-label fw-bold">Filtrar por año:</label>
          <select name="año" id="año" class="form-select">
            <option value="">Todos los años</option>
            <?php foreach($anios as $anio): ?>
              <option value="<?= $anio ?>" <?= ($añoFiltro == $anio) ? 'selected' : '' ?>><?= $anio ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-warning mt-md-4">Filtrar</button>
          <?php if($añoFiltro): ?>
            <a href="?pid=<?= base64_encode('presentacion/ConsultarVentas.php') ?>" class="btn btn-outline-secondary mt-md-4 ms-2">Limpiar</a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="mb-0">Ventas por Mes</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Total Ventas</th>
                <th>Cantidad Ventas</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($ventasPorMes as $ventaMes): ?>
                <tr>
                  <td><?= $ventaMes['año'] ?></td>
                  <td><?= DateTime::createFromFormat('!m', $ventaMes['mes'])->format('F') ?></td>
                  <td>$<?= number_format($ventaMes['total_ventas'], 2) ?></td>
                  <td><?= $ventaMes['cantidad_ventas'] ?></td>
                  <td>
                    <a href="?pid=<?= base64_encode('presentacion/ConsultarVentas.php') ?>&mes=<?= $ventaMes['mes'] ?>&año=<?= $ventaMes['año'] ?>" class="btn btn-sm btn-primary">
                      Ver Detalle
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php if(isset($ventasPorPlato) && !empty($ventasPorPlato)): ?>
      <div class="card mt-4" id="detalle-ventas">
        <div class="card-header bg-primary text-white">
          <h3 class="mb-0">Detalle de Ventas - <?= DateTime::createFromFormat('!m', $mesFiltro)->format('F') ?> <?= $añoFiltro ?></h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Plato</th>
                  <th>Cantidad Vendida</th>
                  <th>Total Vendido</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($ventasPorPlato as $venta): ?>
                  <tr>
                    <td><?= htmlspecialchars($venta->getPlato()->getNombre()) ?></td>
                    <td><?= $venta->getCantidadPlatos() ?></td>
                    <td>$<?= number_format($venta->getSubtotal(), 2) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <footer>
    <p class="mb-0">&copy; 2025 Colombiano, Coma Contento. Todos los derechos reservados.</p>
  </footer>

  <a href="?pid=<?= base64_encode('presentacion/Inicio.php') ?>" class="btn btn-warning btn-flotante">
    <i class="fas fa-home"></i>
  </a>
</body>
</html>