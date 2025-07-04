<?php
Class PlatoIngrediente{
    private $plato;
    private $ingrediente;
    private $cantidad;
    
    public function __construct($plato = "", $ingrediente = "", $cantidad = ""){
        $this -> plato = $plato;
        $this -> ingrediente = $ingrediente;
        $this -> cantidad = $cantidad;
    }
    
    public function getPlato() {
        return $this -> plato;
    }
    
    public function getIngrediente() {
        return $this -> ingrediente;
    }
    
    public function getCantidad() {
        return $this -> cantidad;
    }
    
    public function setPlato($plato){
        $this -> plato =$plato;
    }
    
    public function setIngrediente($ingrediente){
        $this -> ingrediente =$ingrediente;
    }
    
    public function setCantidad($cantidad){
        $this -> cantidad =$cantidad;
    }
}
?>