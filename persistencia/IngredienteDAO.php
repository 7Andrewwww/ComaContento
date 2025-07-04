<?php
class IngredienteDAO {
    private $id_ing;
    private $nombre;
    private $unidad_medida;
    
    public function __construct($id_ing="", $nombre="", $unidad_medida="") {
        $this->id_ing = $id_ing;
        $this->nombre = $nombre;
        $this->unidad_medida = $unidad_medida;
    }
    
    public function consultarTodos() {
        return "SELECT id_ing, nombre, unidad_medida FROM ingrediente ORDER BY nombre";
    }
}