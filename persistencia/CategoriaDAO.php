<?php
class CategoriaDAO {
    private $id_cat;
    private $nombre;
    
    public function __construct($id_cat="", $nombre="") {
        $this->id_cat = $id_cat;
        $this->nombre = $nombre;
    }
    
    public function consultarTodos() {
        return "SELECT id_cat, nombre FROM categoria ORDER BY nombre";
    }
}
?>