<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/RegionDAO.php");

    class Region {
        private $id_reg;
        private $nombre;
        
        public function __construct($id_reg = "", $nombre = "") {
            $this->id_reg = $id_reg;
            $this->nombre = $nombre;
        }
        
        public function getId() { return $this->id_reg; }
        public function getNombre() { return $this->nombre; }
        
        public static function consultarTodos() {
            $conexion = new Conexion();
            $regionDAO = new RegionDAO();
            $conexion->abrir();
            $conexion->ejecutar($regionDAO->consultarTodos());
            $regiones = array();
            while (($datos = $conexion->registro()) != null) {
                $regiones[] = new Region($datos[0], $datos[1]);
            }
            $conexion->cerrar();
            return $regiones;
        }
    }
?>