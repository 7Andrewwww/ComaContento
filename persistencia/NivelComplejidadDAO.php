<?php
class NivelComplejidadDAO {
    private $id_nivel;
    private $nombre;
    
    public function __construct($id_nivel="", $nombre="") {
        $this->id_nivel = $id_nivel;
        $this->nombre = $nombre;
    }
    
    public function consultarTodos() {
        return "SELECT id_nivel, nombre FROM nivel_complejidad ORDER BY nombre";
    }
    
    public function consultarPorId($id_nivel) {
        return "SELECT id_nivel, nombre FROM nivel_complejidad WHERE id_nivel = $id_nivel";
    }
}
?>