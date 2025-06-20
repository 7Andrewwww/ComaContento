<?php
class VentasDAO {
    private $id_venta;
    private $fecha;
    private $valor_total;
    private $id_plato;
    private $nombre_plato;
    private $cantidad_platos;
    private $precio_unitario;
    private $subtotal;
    
    public function __construct($id_venta="", $fecha="", $valor_total="", $id_plato="",
        $nombre_plato="", $cantidad_platos="", $precio_unitario="", $subtotal="") {
            $this->id_venta = $id_venta;
            $this->fecha = $fecha;
            $this->valor_total = $valor_total;
            $this->id_plato = $id_plato;
            $this->nombre_plato = $nombre_plato;
            $this->cantidad_platos = $cantidad_platos;
            $this->precio_unitario = $precio_unitario;
            $this->subtotal = $subtotal;
    }
    
    public function consultarVentasPorMes($año = null) {
        $sentencia = "SELECT
                        YEAR(v.fecha) as año,
                        MONTH(v.fecha) as mes,
                        SUM(v.valor_total) as total_ventas,
                        COUNT(v.id_venta) as cantidad_ventas
                      FROM venta v";
        
        if ($año !== null) {
            $sentencia .= " WHERE YEAR(v.fecha) = " . $año;
        }
        
        $sentencia .= " GROUP BY YEAR(v.fecha), MONTH(v.fecha)
                         ORDER BY año DESC, mes DESC";
        
        return $sentencia;
    }
    
    public function consultarVentasPorPlato($mes, $año) {
        $sentencia = "SELECT
                        p.id_plato,
                        p.nombre as nombre_plato,
                        SUM(dv.cantidad_platos) as cantidad_vendida,
                        SUM(dv.subtotal) as total_vendido
                      FROM detalle_venta dv
                      JOIN plato p ON dv.id_plato = p.id_plato
                      JOIN venta v ON dv.id_venta = v.id_venta
                      WHERE MONTH(v.fecha) = " . $mes . " AND YEAR(v.fecha) = " . $año . "
                      GROUP BY p.id_plato, p.nombre
                      ORDER BY total_vendido DESC";
        
        return $sentencia;
    }
    
    public function consultarAniosDisponibles() {
        return "SELECT DISTINCT YEAR(fecha) as año FROM venta ORDER BY año DESC";
    }
    
    public function consultarDetalleVenta($id_venta) {
        return "SELECT
                  v.id_venta,
                  v.fecha,
                  v.valor_total,
                  p.id_plato,
                  p.nombre as nombre_plato,
                  dv.cantidad_platos,
                  dv.precio_unitario,
                  dv.subtotal
                FROM venta v
                JOIN detalle_venta dv ON v.id_venta = dv.id_venta
                JOIN plato p ON dv.id_plato = p.id_plato
                WHERE v.id_venta = " . $id_venta;
    }
    
   
    public function consultarVentasPorPlatoRegion($mes = null, $año = null) {
        $sentencia = "SELECT
                r.id_reg,
                r.nombre as nombre_region,
                p.id_plato,
                p.nombre as nombre_plato,
                SUM(dv.cantidad_platos) as cantidad_vendida,
                SUM(dv.subtotal) as total_vendido
              FROM detalle_venta dv
              JOIN plato p ON dv.id_plato = p.id_plato
              JOIN region r ON p.id_reg = r.id_reg
              JOIN venta v ON dv.id_venta = v.id_venta";
        
        $conditions = [];
        
        // Validar que mes sea un número válido
        if (!is_null($mes) && is_numeric($mes) && $mes >= 1 && $mes <= 12) {
            $conditions[] = "MONTH(v.fecha) = " . intval($mes);
        }
        
        // Validar que año sea un número válido (entre 2000 y 2100 como ejemplo)
        if (!is_null($año) && is_numeric($año)) {
            $año = intval($año);
            if ($año >= 2000 && $año <= 2100) {
                $conditions[] = "YEAR(v.fecha) = " . $año;
            }
        }
        
        if (!empty($conditions)) {
            $sentencia .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sentencia .= " GROUP BY r.id_reg, r.nombre, p.id_plato, p.nombre
                ORDER BY r.nombre, total_vendido DESC";
        
        return $sentencia;
    }
    
    // Agregar este nuevo método a la clase VentasDAO
    public function consultarVentasPorMomentoConsumo($mes = null, $año = null) {
        $sentencia = "SELECT
                    mc.id_mc,
                    mc.momento as momento_consumo,
                    p.id_plato,
                    p.nombre as nombre_plato,
                    SUM(dv.cantidad_platos) as cantidad_vendida,
                    SUM(dv.subtotal) as total_vendido
                  FROM detalle_venta dv
                  JOIN plato p ON dv.id_plato = p.id_plato
                  JOIN momento_consumo mc ON p.id_mc = mc.id_mc
                  JOIN venta v ON dv.id_venta = v.id_venta";
        
        $conditions = [];
        
        // Validar que mes sea un número válido
        if (!is_null($mes) && is_numeric($mes) && $mes >= 1 && $mes <= 12) {
            $conditions[] = "MONTH(v.fecha) = " . intval($mes);
        }
        
        // Validar que año sea un número válido (entre 2000 y 2100 como ejemplo)
        if (!is_null($año) && is_numeric($año)) {
            $año = intval($año);
            if ($año >= 2000 && $año <= 2100) {
                $conditions[] = "YEAR(v.fecha) = " . $año;
            }
        }
        
        if (!empty($conditions)) {
            $sentencia .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sentencia .= " GROUP BY mc.id_mc, mc.momento, p.id_plato, p.nombre
                    ORDER BY mc.momento, total_vendido DESC";
        
        return $sentencia;
    }
    
}