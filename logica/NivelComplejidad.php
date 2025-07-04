<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/NivelComplejidadDAO.php");

class NivelComplejidad {
    private $id_nivel;
    private $nombre;
    
    public function __construct($id_nivel = "", $nombre = "") {
        $this->id_nivel = $id_nivel;
        $this->nombre = $nombre;
    }
    
    public function getId() { return $this->id_nivel; }
    public function getNombre() { return $this->nombre; }
    
    public static function consultarTodos() {
        $conexion = new Conexion();
        $nivelDAO = new NivelComplejidadDAO();
        $conexion->abrir();
        $conexion->ejecutar($nivelDAO->consultarTodos());
        $niveles = array();
        while (($datos = $conexion->registro()) != null) {
            $niveles[] = new NivelComplejidad($datos[0], $datos[1]);
        }
        $conexion->cerrar();
        return $niveles;
    }
    
    public static function consultarPorId($id_nivel) {
        $conexion = new Conexion();
        $nivelDAO = new NivelComplejidadDAO();
        $conexion->abrir();
        $conexion->ejecutar($nivelDAO->consultarPorId($id_nivel));
        $nivel = null;
        if (($datos = $conexion->registro()) != null) {
            $nivel = new NivelComplejidad($datos[0], $datos[1]);
        }
        $conexion->cerrar();
        return $nivel;
    }
}
?>