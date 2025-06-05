<?php
require_once(__DIR__ . '/../logica/Plato.php');
require_once(__DIR__ . '/../logica/Ingrediente.php');
require_once(__DIR__ . '/../logica/Categoria.php');
require_once(__DIR__ . '/../logica/Region.php');
require_once(__DIR__ . '/../logica/MomentoConsumo.php');
require_once(__DIR__ . '/../logica/NivelComplejidad.php');

$ingredientes = Ingrediente::consultarTodos();
$categorias = Categoria::consultarTodos();
$regiones = Region::consultarTodos();
$momentos = MomentoConsumo::consultarTodos();
$niveles = NivelComplejidad::consultarTodos();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio_base = $_POST['precio_base'];
    $id_nivel = $_POST['id_nivel'];
    $foto = $_POST['foto'];
    $id_cat = $_POST['id_cat'];
    $id_mc = $_POST['id_mc'];
    $id_reg = $_POST['id_reg'];
    
    // Procesar ingredientes
    $ingredientes_plato = [];
    foreach ($_POST['ingredientes'] as $id_ing => $cantidad) {
        if ($cantidad > 0) {
            $ingredientes_plato[] = [
                'id_ing' => $id_ing,
                'cantidad' => $cantidad
            ];
        }
    }
    
    if (Plato::crear($nombre, $descripcion, $precio_base, $id_nivel, $foto,
        $id_cat, $id_mc, $id_reg, $ingredientes_plato)) {
            $mensaje = "Plato creado exitosamente!";
        } else {
            $error = "Error al crear el plato";
        }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Plato | Colombiano, Coma Contento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Mantenemos los mismos estilos que en VentasPorRegion.php */
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
    
    .momento-header {
      background-color: #003893;
      color: white;
      padding: 10px 15px;
      border-radius: 8px;
      margin-top: 20px;
      margin-bottom: 10px;
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
    }
  </style>
</head>
<body>
    <div class="container py-5">
        <h1>Crear Nuevo Plato</h1>
        
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?= $mensaje ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Plato</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Precio Base</label>
                        <input type="number" name="precio_base" class="form-control" step="0.01" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">URL de la Foto</label>
                        <input type="url" name="foto" class="form-control">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <select name="id_cat" class="form-select" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria->getId() ?>"><?= $categoria->getNombre() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Región</label>
                        <select name="id_reg" class="form-select" required>
                            <?php foreach ($regiones as $region): ?>
                                <option value="<?= $region->getId() ?>"><?= $region->getNombre() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Momento de Consumo</label>
                        <select name="id_mc" class="form-select" required>
                            <?php foreach ($momentos as $momento): ?>
                                <option value="<?= $momento->getId() ?>"><?= $momento->getMomento() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nivel de Complejidad</label>
                        <select name="id_nivel" class="form-select" required>
                            <?php foreach ($niveles as $nivel): ?>
                                <option value="<?= $nivel->getId() ?>"><?= $nivel->getNombre() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <h3 class="mt-4">Ingredientes</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ingrediente</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ingredientes as $ingrediente): ?>
                            <tr>
                                <td><?= $ingrediente->getNombre() ?></td>
                                <td>
                                    <input type="number" name="ingredientes[<?= $ingrediente->getId() ?>]" 
                                           class="form-control" step="0.01" min="0" value="0">
                                </td>
                                <td><?= $ingrediente->getUnidadMedida() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar Plato</button>
        </form>
    </div>
</body>
</html>