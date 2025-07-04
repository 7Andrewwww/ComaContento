<?php
$mensaje = "";
$error = "";

if(isset($_POST['crear'])) {
    try {
        $foto = 'img/platos/default.jpg';
        
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $directorio = "img/platos/";
            if(!is_dir($directorio)) {
                mkdir($directorio, 0755, true);
            }
            
            $nombreArchivo = uniqid() . '_' . basename($_FILES['foto']['name']);
            $rutaCompleta = $directorio . $nombreArchivo;
            
            $tipoArchivo = strtolower(pathinfo($rutaCompleta, PATHINFO_EXTENSION));
            $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif');
            
            if(in_array($tipoArchivo, $extensionesPermitidas)) {
                if(move_uploaded_file($_FILES['foto']['tmp_name'], $rutaCompleta)) {
                    $foto = $rutaCompleta;
                } else {
                    throw new Exception("Error al subir la imagen");
                }
            } else {
                throw new Exception("Solo se permiten archivos JPG, JPEG, PNG o GIF");
            }
        }
        
        $nivel = new NivelComplejidad($_POST['nivel']);
        $categoria = new Categoria($_POST['categoria']);
        $momento = new MomentoConsumo($_POST['momento']);
        $region = new Region($_POST['region']);
        $encargado = new Encargado($_POST['encargado']);
        
        $plato = new Plato(
            $_POST['id'],
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['precio'],
            $nivel,
            $foto,
            $categoria,
            $momento,
            $region,
            $encargado
            );
        
        $ingredientes = array();
        if(isset($_POST['ingredientes']) && is_array($_POST['ingredientes'])) {
            foreach($_POST['ingredientes'] as $id_ing) {
                if(isset($_POST['cantidad_'.$id_ing]) && $_POST['cantidad_'.$id_ing] > 0) {
                    $ingredientes[] = array(
                        'id' => $id_ing,
                        'cantidad' => $_POST['cantidad_'.$id_ing]
                    );
                }
            }
        }
        
        if($plato->crear($ingredientes)) {
            $mensaje = "Plato creado exitosamente";
        } else {
            $error = "Error al crear el plato";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$niveles = NivelComplejidad::consultarTodos();
$categorias = Categoria::consultarTodos();
$momentos = MomentoConsumo::consultarTodos();
$regiones = Region::consultarTodos();
$encargados = Encargado::consultarTodos();
$ingredientes = Plato::listarTodosIngredientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Plato</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        .form-container {
            color: #222;
             background: rgba(255, 255, 255, 0.85); 
             backdrop-filter: blur(8px);
              -webkit-backdrop-filter: blur(8px);
              border-radius: 16px;
              padding: 30px;
              max-width: 800px;
              margin: 40px auto;
               box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}


        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-top: 5px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #ff9800;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e68a00;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.8);
            color: #fff;
        }

        .alert-danger {
            background-color: rgba(244, 67, 54, 0.8);
            color: #fff;
        }

        .ingrediente-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .cantidad-container {
            margin-top: 10px;
        }

        .hidden {
            display: none;
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

<div class="form-container">
    <h1>Crear Nuevo Plato</h1>

    <?php if($mensaje != ""): ?>
        <div class="alert alert-success"><?php echo $mensaje ?></div>
    <?php endif; ?>

    <?php if($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error ?></div>
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="id">ID del Plato:</label>
        <input type="text" id="id" name="id" required>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="precio">Precio Base:</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" required>

        <label for="foto">Foto del Plato:</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <label for="nivel">Nivel de Complejidad:</label>
        <select id="nivel" name="nivel">
            <option value="">Seleccione...</option>
            <?php foreach($niveles as $nivel): ?>
                <option value="<?php echo $nivel->getId() ?>"><?php echo $nivel->getNombre() ?></option>
            <?php endforeach; ?>
        </select>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria">
            <option value="">Seleccione...</option>
            <?php foreach($categorias as $cat): ?>
                <option value="<?php echo $cat->getId() ?>"><?php echo $cat->getNombre() ?></option>
            <?php endforeach; ?>
        </select>

        <label for="momento">Momento de Consumo:</label>
        <select id="momento" name="momento">
            <option value="">Seleccione...</option>
            <?php foreach($momentos as $mom): ?>
                <option value="<?php echo $mom->getId() ?>"><?php echo $mom->getMomento() ?></option>
            <?php endforeach; ?>
        </select>

        <label for="region">Región:</label>
        <select id="region" name="region">
            <option value="">Seleccione...</option>
            <?php foreach($regiones as $reg): ?>
                <option value="<?php echo $reg->getId() ?>"><?php echo $reg->getNombre() ?></option>
            <?php endforeach; ?>
        </select>

        <label for="encargado">Encargado:</label>
        <select id="encargado" name="encargado">
            <option value="">Seleccione...</option>
            <?php foreach($encargados as $enc): ?>
                <option value="<?php echo $enc->getId() ?>"><?php echo $enc->getNombre() ?></option>
            <?php endforeach; ?>
        </select>

        <h3>Ingredientes</h3>
        <div id="ingredientes-container">
            <?php foreach($ingredientes as $ing): ?>
                <div class="ingrediente-item">
                    <input type="checkbox" name="ingredientes[]" value="<?php echo $ing->getId() ?>" 
                           id="ing_<?php echo $ing->getId() ?>" class="ingrediente-check">
                    <label for="ing_<?php echo $ing->getId() ?>"><?php echo $ing->getNombre() ?></label>

                    <div class="cantidad-container hidden">
                        <label>Cantidad:</label>
                        <input type="number" name="cantidad_<?php echo $ing->getId() ?>" step="0.01" min="0.01">
                        <span><?php echo $ing->getUnidadMedida() ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" name="crear">Crear Plato</button>
    </form>
</div>

<script>
    document.querySelectorAll('.ingrediente-check').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.ingrediente-item').querySelector('.cantidad-container');
            if(this.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        });
    });
</script>
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
