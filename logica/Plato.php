<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
require_once(__DIR__ . '/../persistencia/PlatoDAO.php');
class Plato {
    private $id_plato;
    private $nombre;
    private $descripcion;
    private $precio_base;
    private $nivelComplejidad;
    private $foto;
    
    public function __construct($id_plato = "", $nombre = "", $descripcion = "",
        $precio_base = 0, $nivelComplejidad = null, $foto = null) {
            $this->id_plato = $id_plato;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio_base = $precio_base;
            $this->nivelComplejidad = $nivelComplejidad;
            $this->foto = $foto;
    }
    
    public function getId() { return $this->id_plato; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecioBase() { return $this->precio_base; }
    public function getNivelComplejidad() { return $this->nivelComplejidad; }
    public function getFoto() { return $this->foto; }
    
    public static function consultarPorId($id_plato) {
        $conexion = new Conexion();
        $platoDAO = new PlatoDAO();
        $conexion->abrir();
        $conexion->ejecutar($platoDAO->consultarPorId($id_plato));
        $plato = null;
        if(($datos = $conexion->registro()) != null) {
            $nivel = NivelComplejidad::consultarPorId($datos[4]);
            $plato = new Plato($datos[0], $datos[1], $datos[2], $datos[3], $nivel, $datos[5]);
        }
        $conexion->cerrar();
        return $plato;
    }
    
    public static function crear($nombre, $descripcion, $precio_base, $id_nivel, $foto,
        $id_cat, $id_mc, $id_reg, $ingredientes_plato) {
            $conexion = new Conexion();
            $platoDAO = new PlatoDAO("", $nombre, $descripcion, $precio_base,
                $id_nivel, $foto, $id_cat, $id_mc, $id_reg);
            
            $conexion->abrir();
            $conexion->ejecutar($platoDAO->insertar());
            
            // Obtener el ID del plato recién insertado
            $conexion->ejecutar($platoDAO->ultimoIdInsertado());
            $datos = $conexion->registro();
            $id_plato = $datos[0];
            
            // Insertar los ingredientes del plato
            foreach ($ingredientes_plato as $ingrediente) {
                $id_ing = $ingrediente['id_ing'];
                $cantidad = $ingrediente['cantidad'];
                $conexion->ejecutar($platoDAO->agregarIngrediente($id_ing, $cantidad));
            }
            
            $conexion->cerrar();
            return true;
    }
}