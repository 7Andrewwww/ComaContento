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
    private $id_enc;
    
    public function __construct($id_plato = "", $nombre = "", $descripcion = "", $precio_base = "",
        $id_nivel = "", $foto = "", $id_cat = "", $id_mc = "", $id_reg = "", $id_enc = "") {
            $this->id_plato = $id_plato;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio_base = $precio_base;
            $this->id_nivel = $id_nivel;
            $this->foto = $foto;
            $this->id_cat = $id_cat;
            $this->id_mc = $id_mc;
            $this->id_reg = $id_reg;
            $this->id_enc = $id_enc;
    }
    
    public function consultar() {
        return "SELECT p.nombre, p.descripcion, p.precio_base, p.foto,
                       p.id_nivel, nc.nombre as nivel_nombre,
                       p.id_cat, c.nombre as categoria_nombre,
                       p.id_mc, mc.momento as momento_consumo,
                       p.id_reg, r.nombre as region_nombre,
                       p.id_enc, e.nombre as encargado_nombre
                FROM plato p
                LEFT JOIN nivel_complejidad nc ON p.id_nivel = nc.id_nivel
                LEFT JOIN categoria c ON p.id_cat = c.id_cat
                LEFT JOIN momento_consumo mc ON p.id_mc = mc.id_mc
                LEFT JOIN region r ON p.id_reg = r.id_reg
                LEFT JOIN encargado e ON p.id_enc = e.id_enc
                WHERE p.id_plato = '" . $this->id_plato . "'";
    }
    
    public function consultarTodos() {
        return "SELECT p.id_plato, p.nombre, p.descripcion, p.precio_base, p.foto,
                       nc.nombre as nivel, c.nombre as categoria,
                       mc.momento as momento, r.nombre as region
                FROM plato p
                LEFT JOIN nivel_complejidad nc ON p.id_nivel = nc.id_nivel
                LEFT JOIN categoria c ON p.id_cat = c.id_cat
                LEFT JOIN momento_consumo mc ON p.id_mc = mc.id_mc
                LEFT JOIN region r ON p.id_reg = r.id_reg
                ORDER BY p.nombre";
    }
    
    // Código corregido en PlatoDAO.php::crear()
// ...
public function crear() {
    $sql = "INSERT INTO plato (id_plato, nombre, descripcion, precio_base, id_nivel, foto, id_cat, id_mc, id_reg, id_enc)
    VALUES ('" . $this->id_plato . "',
            '" . $this->nombre . "',
            '" . $this->descripcion . "',
            " . $this->precio_base . ",
            " . (empty($this->id_nivel) ? 'NULL' : $this->id_nivel) . ",
            '" . $this->foto . "',
            " . (empty($this->id_cat) ? 'NULL' : $this->id_cat) . ",
            " . (empty($this->id_mc) ? 'NULL' : $this->id_mc) . ",
            " . (empty($this->id_reg) ? 'NULL' : $this->id_reg) . ",
            " . (empty($this->id_enc) ? 'NULL' : $this->id_enc) . ")";

    error_log("SQL CREAR PLATO: $sql"); // Mantén esto para depuración

    return $sql;
}
    
    public function agregarIngrediente($id_ing, $cantidad) {
        return "INSERT INTO plato_ingrediente (id_plato, id_ing, cantidad)
                VALUES ('" . $this->id_plato . "',
                        '" . $id_ing . "',
                        " . $cantidad . ")";
    }
    
    public function consultarIngredientes() {
        return "SELECT i.id_ing, i.nombre, i.unidad_medida, pi.cantidad
                FROM plato_ingrediente pi
                JOIN ingrediente i ON pi.id_ing = i.id_ing
                WHERE pi.id_plato = '" . $this->id_plato . "'";
    }
    
    public function consultarTodosIngredientes() {
        return "SELECT id_ing, nombre, unidad_medida FROM ingrediente ORDER BY nombre";
    }
}
?>