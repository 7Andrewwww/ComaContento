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
}