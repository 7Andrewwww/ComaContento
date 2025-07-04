<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/PlatoDAO.php");
require_once("logica/NivelComplejidad.php");
require_once("logica/Categoria.php");
require_once("logica/MomentoConsumo.php");
require_once("logica/Region.php");
require_once("logica/Encargado.php");
require_once("logica/Ingrediente.php");

class Plato {
    private $id_plato;
    private $nombre;
    private $descripcion;
    private $precio_base;
    private $nivel_complejidad;
    private $foto;
    private $categoria;
    private $momento_consumo;
    private $region;
    private $encargado;
    private $ingredientes;
    
    public function __construct($id_plato = "", $nombre = "", $descripcion = "", $precio_base = "",
        $nivel_complejidad = "", $foto = "", $categoria = "",
        $momento_consumo = "", $region = "", $encargado = "") {
            $this->id_plato = $id_plato;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio_base = $precio_base;
            $this->nivel_complejidad = $nivel_complejidad;
            $this->foto = $foto;
            $this->categoria = $categoria;
            $this->momento_consumo = $momento_consumo;
            $this->region = $region;
            $this->encargado = $encargado;
            $this->ingredientes = array();
    }
    
    public function getId() { return $this->id_plato; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecioBase() { return $this->precio_base; }
    public function getNivelComplejidad() { return $this->nivel_complejidad; }
    public function getFoto() { return $this->foto; }
    public function getCategoria() { return $this->categoria; }
    public function getMomentoConsumo() { return $this->momento_consumo; }
    public function getRegion() { return $this->region; }
    public function getEncargado() { return $this->encargado; }    
    public function getIngredientes() { return $this->ingredientes; }
    
    public function consultar() {
        $conexion = new Conexion();
        $platoDAO = new PlatoDAO($this->id_plato);
        $conexion->abrir();
        $conexion->ejecutar($platoDAO->consultar());
        $datos = $conexion->registro();
        
        $this->nombre = $datos[0];
        $this->descripcion = $datos[1];
        $this->precio_base = $datos[2];
        $this->foto = $datos[3];
        $this->nivel_complejidad = new NivelComplejidad($datos[4], $datos[5]);
        $this->categoria = new Categoria($datos[6], $datos[7]);
        $this->momento_consumo = new MomentoConsumo($datos[8], $datos[9]);
        $this->region = new Region($datos[10], $datos[11]);
        $this->encargado = new Encargado($datos[12], $datos[13]);
        
        // Consultar ingredientes (sin cantidad)
        $conexion->ejecutar($platoDAO->consultarIngredientes());
        while($ing = $conexion->registro()) {
            $this->ingredientes[] = new Ingrediente($ing[0], $ing[1], $ing[2]);
        }
        
        $conexion->cerrar();
    }
    
    public static function consultarTodos() {
        $conexion = new Conexion();
        $platoDAO = new PlatoDAO();
        $conexion->abrir();
        $conexion->ejecutar($platoDAO->consultarTodos());
        $platos = array();
        
        while($datos = $conexion->registro()) {
            $plato = new Plato(
                $datos[0],
                $datos[1],
                $datos[2],
                $datos[3],
                $datos[4],
                new NivelComplejidad("", $datos[5]),
                new Categoria("", $datos[6]),
                new MomentoConsumo("", $datos[7]),
                new Region("", $datos[8])
                );
            array_push($platos, $plato);
        }
        
        $conexion->cerrar();
        return $platos;
    }
    
    public static function listarTodosIngredientes() {
        $conexion = new Conexion();
        $platoDAO = new PlatoDAO();
        $conexion->abrir();
        $conexion->ejecutar($platoDAO->consultarTodosIngredientes());
        $ingredientes = array();
        
        while($datos = $conexion->registro()) {
            $ingrediente = new Ingrediente($datos[0], $datos[1], $datos[2]);
            array_push($ingredientes, $ingrediente);
        }
        
        $conexion->cerrar();
        return $ingredientes;
    }
    
    // En logica/Plato.php
public function crear($ingredientes = array()) {
        $conexion = new Conexion();
        $platoDAO = new PlatoDAO(
            $this->id_plato,
            $this->nombre,
            $this->descripcion,
            $this->precio_base,
            $this->nivel_complejidad->getId(),
            $this->foto,
            $this->categoria->getId(),
            $this->momento_consumo->getId(),
            $this->region->getId(),
            $this->encargado->getId()
        );
        
        $conexion->abrir();
        
        // Verificar si el plato ya existe
        $conexion->ejecutar("SELECT id_plato FROM plato WHERE id_plato = '" . $this->id_plato . "'");
        if($conexion->filas() > 0) {
            $conexion->cerrar();
            throw new Exception("El ID del plato ya existe. Por favor, usa otro ID.");
        }
        
        // Crear el plato
        // Ahora ejecutamos y el método ejecutar de Conexion.php devuelve true/false
        $exitoCreacionPlato = $conexion->ejecutar($platoDAO->crear());
        
        if ($exitoCreacionPlato) {
            // Si el plato principal se creó correctamente, intentamos agregar los ingredientes
            if(!empty($ingredientes)) {
                foreach($ingredientes as $ing) {
                    // Asegúrate de que $ing['id'] y $ing['cantidad'] existan y sean válidos
                    if (isset($ing['id']) && isset($ing['cantidad'])) {
                        $exitoIngrediente = $conexion->ejecutar($platoDAO->agregarIngrediente($ing['id'], $ing['cantidad']));
                        // Opcional: Si la adición de un ingrediente falla, puedes lanzar una excepción o registrar el error
                        // if (!$exitoIngrediente) {
                        //     error_log("Error al agregar ingrediente " . $ing['id'] . " al plato " . $this->id_plato);
                        // }
                    } else {
                        error_log("Datos de ingrediente incompletos para el plato " . $this->id_plato);
                    }
                }
            }
            $conexion->cerrar();
            return true; // Éxito en la creación del plato (y se intentó agregar ingredientes)
        } else {
            // Esto se ejecutaría si la consulta INSERT en la DB fallara por alguna razón (ej. restricción, tipo de dato)
            $conexion->cerrar();
            throw new Exception("Error al insertar el plato en la base de datos. Verifique los datos proporcionados.");
        }
    }
}
?>