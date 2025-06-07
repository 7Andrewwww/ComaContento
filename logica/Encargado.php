<?php
require_once("persistencia/Conexion.php");
class Encargado {
    private $id_encargado;
    private $nombre;
    
    public function __construct($id_encargado = "", $nombre = "") {
        $this->id_encargado = $id_encargado;
        $this->nombre = $nombre;
    }
    
    // Getters y setters...
    public function getId() { return $this->id_encargado; }
    public function getNombre() { return $this->nombre; }
    
    // Método estático para consultar todos los encargados
    public static function consultarTodos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar("SELECT id_enc, nombre FROM encargado");
        $encargados = array();
        
        while ($datos = $conexion->registro()) {
            $encargado = new Encargado($datos[0], $datos[1]);
            array_push($encargados, $encargado);
        }
        
        $conexion->cerrar();
        return $encargados;
    }
}
?>