<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/CategoriaDAO.php");

class Categoria {
    private $id_cat;
    private $nombre;
    
    public function __construct($id_cat = "", $nombre = "") {
        $this->id_cat = $id_cat;
        $this->nombre = $nombre;
    }
    
    public function getId() { return $this->id_cat; }
    public function getNombre() { return $this->nombre; }
    
    public static function consultarTodos() {
        $conexion = new Conexion();
        $categoriaDAO = new CategoriaDAO();
        $conexion->abrir();
        $conexion->ejecutar($categoriaDAO->consultarTodos());
        $categorias = array();
        while (($datos = $conexion->registro()) != null) {
            $categorias[] = new Categoria($datos[0], $datos[1]);
        }
        $conexion->cerrar();
        return $categorias;
    }
}
?>