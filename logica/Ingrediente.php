<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/IngredienteDAO.php");

class Ingrediente {
    private $id_ing;
    private $nombre;
    private $unidad_medida;
    
    public function __construct($id_ing = "", $nombre = "", $unidad_medida = "") {
        $this->id_ing = $id_ing;
        $this->nombre = $nombre;
        $this->unidad_medida = $unidad_medida;
    }
    
    // Getters
    public function getId() { return $this->id_ing; }
    public function getNombre() { return $this->nombre; }
    public function getUnidadMedida() { return $this->unidad_medida; }
    
    // Setters
    public function setId($id_ing) { $this->id_ing = $id_ing; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setUnidadMedida($unidad_medida) { $this->unidad_medida = $unidad_medida; }
    
    public static function consultarTodos() {
        $conexion = new Conexion();
        $ingredienteDAO = new IngredienteDAO();
        $conexion->abrir();
        $conexion->ejecutar($ingredienteDAO->consultarTodos());
        $ingredientes = array();
        while (($datos = $conexion->registro()) != null) {
            $ingredientes[] = new Ingrediente($datos[0], $datos[1], $datos[2]);
        }
        $conexion->cerrar();
        return $ingredientes;
    }
}
?>