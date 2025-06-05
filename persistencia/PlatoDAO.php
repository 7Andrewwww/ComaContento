<?php
class PlatoDAO {
    private $id_plato;
    private $nombre;
    private $descripcion;
    private $precio_base;
    private $id_nivel;
    private $foto;
    private $id_cat;
    private $id_mc;
    private $id_reg;
    
    public function __construct($id_plato="", $nombre="", $descripcion="", $precio_base="",
        $id_nivel="", $foto="", $id_cat="", $id_mc="", $id_reg="") {
            $this->id_plato = $id_plato;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio_base = $precio_base;
            $this->id_nivel = $id_nivel;
            $this->foto = $foto;
            $this->id_cat = $id_cat;
            $this->id_mc = $id_mc;
            $this->id_reg = $id_reg;
    }
    
    public function insertar() {
        return "INSERT INTO plato (nombre, descripcion, precio_base, id_nivel, foto, id_cat, id_mc, id_reg)
                VALUES ('$this->nombre', '$this->descripcion', $this->precio_base,
                        $this->id_nivel, '$this->foto', $this->id_cat, $this->id_mc, $this->id_reg)";
    }
    
    public function ultimoIdInsertado() {
        return "SELECT LAST_INSERT_ID()";
    }
    
    public function agregarIngrediente($id_ing, $cantidad) {
        return "INSERT INTO plato_ingrediente (id_plato, id_ing, cantidad)
                VALUES ($this->id_plato, $id_ing, $cantidad)";
    }
    
    public function consultarPorId($id_plato) {
        return "SELECT id_plato, nombre, descripcion, precio_base, id_nivel, foto,
                   id_cat, id_mc, id_reg
            FROM plato
            WHERE id_plato = $id_plato";
    }
}