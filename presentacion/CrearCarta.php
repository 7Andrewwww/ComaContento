<?php
$mensaje = "";
$error = "";
$platosDisponibles = [];

if(isset($_POST['crear'])) {
    try {
        $carta = new Carta(
            $_POST['id_carta'] ?? '',
            $_POST['fecha_inicio'] ?? '',
            $_POST['fecha_fin'] ?? '',
            isset($_POST['es_vigente']),
            $_POST['descripcion'] ?? ''
            );
        
        if($carta->crear()) {
            if(isset($_POST['platos']) && is_array($_POST['platos'])) {
                foreach($_POST['platos'] as $id_plato) {
                    $plato = new Plato($id_plato);
                    $plato->consultar();
                    $orden = $_POST['orden'][$id_plato] ?? 1;
                    $carta->agregarPlato($plato, $orden);
                }
                $carta->guardarPlatos();
            }
            $mensaje = "Menú creado exitosamente con " .
                (isset($_POST['platos']) ? count($_POST['platos']) : 0) . " platos";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$platosDisponibles = Plato::consultarTodos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Menú</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-top: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            background: linear-gradient(to right, #fcd116, #003893);
            color: white;
        }
        .dish-card {
            transition: all 0.3s;
        }
        .dish-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
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
          <li class="nav-item"><a class="nav-link" href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>#about">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>#modulos">Módulos</a></li>
          <li class="nav-item"><a class="nav-link" href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>#contacto">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Crear Nuevo Menú</h3>
                    </div>
                    <div class="card-body">
                        <?php if(!empty($mensaje)): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
                        <?php endif; ?>
                        
                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_carta" class="form-label">ID del Menú</label>
                                        <input type="text" class="form-control" id="id_carta" name="id_carta" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="es_vigente" name="es_vigente">
                                        <label class="form-check-label" for="es_vigente">Menú vigente</label>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <h5 class="mb-3">Seleccionar Platos</h5>
                            <div class="row">
                                <?php foreach($platosDisponibles as $plato): ?>
<div class="col-md-4 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" 
                       name="platos[]" 
                       value="<?= $plato->getId() ?>" 
                       id="plato-<?= $plato->getId() ?>">
                <label class="form-check-label" for="plato-<?= $plato->getId() ?>">
                    <?= htmlspecialchars($plato->getNombre()) ?>
                </label>
            </div>
            <div class="mt-2">
                <label>Orden:</label>
                <input type="number" name="orden[<?= $plato->getId() ?>]" 
                       min="1" value="1" class="form-control form-control-sm">
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" name="crear" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Guardar Menú
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <a href="?pid=<?php echo base64_encode('presentacion/Inicio.php'); ?>" class="btn btn-warning btn-flotante">
    <i class="fas fa-home"></i>
</a>

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
</body>
</html>