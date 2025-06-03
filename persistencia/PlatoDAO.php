<?php
// persistencia/PlatoDAO.php

class PlatoDAO {
    private $id_plato;
    private $nombre;
    private $descripcion;
    private $precio_base;
    private $nivelComplejidad;
    private $foto;
    private $id_cat;
    private $id_mc;
    private $id_reg;
    private $id_enc;
    
    public function __construct($id_plato = "", $nombre = "", $descripcion = "", $precio_base = "",
        $nivelComplejidad = "", $foto = null, $id_cat = "",
        $id_mc = "", $id_reg = "", $id_enc = "") {
            $this->id_plato = $id_plato;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio_base = $precio_base;
            $this->nivelComplejidad = $nivelComplejidad;
            $this->foto = $foto;
            $this->id_cat = $id_cat;
            $this->id_mc = $id_mc;
            $this->id_reg = $id_reg;
            $this->id_enc = $id_enc;
    }
    
    /**
     * Consulta todos los platos
     * @return string Sentencia SQL
     */
    public function consultarTodos() {
        return "SELECT id_plato, nombre, descripcion, precio_base, nivelComplejidad, foto
                FROM plato
                ORDER BY nombre";
    }
    
    /**
     * Consulta un plato por su ID
     * @param int $id_plato ID del plato
     * @return string Sentencia SQL
     */
    public function consultarPorId($id_plato) {
        return "SELECT id_plato, nombre, descripcion, precio_base, nivelComplejidad, foto
                FROM plato
                WHERE id_plato = " . $id_plato;
    }
    
    /**
     * Inserta un nuevo plato
     * @param string $nombre
     * @param string $descripcion
     * @param float $precio_base
     * @param string $nivelComplejidad
    
     * @param int $id_cat
     * @param int $id_mc
     * @param int $id_reg
     * @param int $id_enc
     * @return string Sentencia SQL
     */
    public function insertar($nombre, $descripcion, $precio_base, $nivelComplejidad, $foto,
        $id_cat, $id_mc, $id_reg, $id_enc) {
            $fotoValue = $foto !== null ? "'" . addslashes($foto) . "'" : "NULL";
            
            return "INSERT INTO plato (nombre, descripcion, precio_base, nivelComplejidad, foto,
                                 id_cat, id_mc, id_reg, id_enc)
                VALUES ('" . $nombre . "', '" . $descripcion . "', " . $precio_base . ",
                       '" . $nivelComplejidad . "', " . $fotoValue . ",
                       " . ($id_cat !== null ? $id_cat : "NULL") . ",
                       " . ($id_mc !== null ? $id_mc : "NULL") . ",
                       " . ($id_reg !== null ? $id_reg : "NULL") . ",
                       " . ($id_enc !== null ? $id_enc : "NULL") . ")";
    }
    
    /**
     * Actualiza la foto de un plato
     * @param int $id_plato
   
     * @return string Sentencia SQL
     */
    public function actualizarFoto($id_plato, $foto) {
        return "UPDATE plato SET foto = '" . addslashes($foto) . "'
                WHERE id_plato = " . $id_plato;
    }
    
    /**
     * Consulta platos por nivel de complejidad
     * @param string $nivelComplejidad
     * @return string Sentencia SQL
     */
    public function consultarPorComplejidad($nivelComplejidad) {
        return "SELECT id_plato, nombre, descripcion, precio_base, nivelComplejidad
                FROM plato
                WHERE nivelComplejidad = '" . $nivelComplejidad . "'
                ORDER BY nombre";
    }
}