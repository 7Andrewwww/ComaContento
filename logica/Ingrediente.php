<?php
Class Ingrediente{
    
    private $idIng;
    private $nombre;
    private $unidadMedida;
    
    public function __construct($idIng = "", $nombre = "", $unidadMedida = ""){
        $this -> idIng = $idIng;
        $this -> nombre = $nombre;
        $this -> unidadMedida = $unidadMedida;
    }
    
    public function getIdIng(){
        return $this -> id_ing;
    }
    
    public function getNombre(){
        return $this -> nombre;
    }
    
    public function getUnidadMedida(){
        return $this -> unidadMedida;
    }
    
    public function setIdIng($idPlato) {
        $this->idPlato = $idPlato;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setUnidadMedida($unidadMedida) {
        $this->unidadMedida = $unidadMedida;
    }
    
}
?>