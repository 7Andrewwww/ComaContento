<?php
class MomentoConsumoDAO {
    private $id_mc;
    private $momento;
    
    public function __construct($id_mc="", $momento="") {
        $this->id_mc = $id_mc;
        $this->momento = $momento;
    }
    
    public function consultarTodos() {
        return "SELECT id_mc, momento FROM momento_consumo ORDER BY momento";
    }
}
?>
