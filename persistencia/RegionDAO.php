<?php
class RegionDAO {
    private $id_reg;
    private $nombre;
    
    public function __construct($id_reg="", $nombre="") {
        $this->id_reg = $id_reg;
        $this->nombre = $nombre;
    }
    
    public function consultarTodos() {
        return "SELECT id_reg, nombre FROM region ORDER BY nombre";
    }
}
?>