<?php
class NivelComplejidad {
    private $id_nivel;
    private $nombre;
    private $descripcion;
    
    public function __construct($id_nivel = "", $nombre = "", $descripcion = "") {
        $this->id_nivel = $id_nivel;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }
    
    public function getId() {
        return $this->id_nivel;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    
    /**
     * Consulta todos los niveles de complejidad
     * @return array Array de objetos NivelComplejidad
     */
    public static function consultarTodos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar("SELECT id_nivel, nombre, descripcion FROM nivel_complejidad ORDER BY id_nivel");
        
        $niveles = array();
        while(($datos = $conexion->registro()) != null) {
            $niveles[] = new NivelComplejidad($datos[0], $datos[1], $datos[2]);
        }
        
        $conexion->cerrar();
        return $niveles;
    }
    
    /**
     * Consulta un nivel por su ID
     * @param int $id_nivel
     * @return NivelComplejidad|null
     */
    public static function consultarPorId($id_nivel) {
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar("SELECT id_nivel, nombre, descripcion FROM nivel_complejidad WHERE id_nivel = " . $id_nivel);
        
        $nivel = null;
        if(($datos = $conexion->registro()) != null) {
            $nivel = new NivelComplejidad($datos[0], $datos[1], $datos[2]);
        }
        
        $conexion->cerrar();
        return $nivel;
    }
}