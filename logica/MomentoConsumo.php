<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/MomentoConsumoDAO.php");

class MomentoConsumo {
    private $id_mc;
    private $momento;
    
    public function __construct($id_mc = "", $momento = "") {
        $this->id_mc = $id_mc;
        $this->momento = $momento;
    }
    
    public function getId() { return $this->id_mc; }
    public function getMomento() { return $this->momento; }
    
    public static function consultarTodos() {
        $conexion = new Conexion();
        $momentoDAO = new MomentoConsumoDAO();
        $conexion->abrir();
        $conexion->ejecutar($momentoDAO->consultarTodos());
        $momentos = array();
        while (($datos = $conexion->registro()) != null) {
            $momentos[] = new MomentoConsumo($datos[0], $datos[1]);
        }
        $conexion->cerrar();
        return $momentos;
    }
}
?>