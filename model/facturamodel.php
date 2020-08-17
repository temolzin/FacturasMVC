<?php
    class FacturaModel extends Model implements CRUD {
        public function __construct()
        {
            parent::__construct();
        }

        public function insert($data) {
            $cliId = $data['cliId'];
            $monId = $data['monId'];
            $fecha = $data['fecha'];
            $subtotal = $data['subtotal'];
            $iva = $data['iva'];
            $total = $data['total'];
            $tipocambio = $data['tipocambio'];

            $valoresInsertar = array(
                ':cliId' => $cliId,
                ':monId' => $monId,
                ':fecha' => $fecha,
                ':subtotal' => $subtotal,
                ':iva' => $iva,
                ':total' => $total,
                ':tipocambio' => $tipocambio
            );

            $sentencia = $this->db->ejecutarAccion("INSERT INTO facturas VALUES (null, :cliId, :monId, :fecha, :subtotal, :iva, :total, :tipocambio)", $valoresInsertar);

            if($sentencia) {
                return 'ok';
            } else {
                return 'error';
            }
        }

        public function update($data)
        {
            $facId = $data['facId'];
            $cliId = $data['cliId'];
            $monId = $data['monId'];
            $fecha = $data['fecha'];
            $subtotal = $data['subtotal'];
            $iva = $data['iva'];
            $total = $data['total'];
            $tipocambio = $data['tipocambio'];

            $valoresActualizar = array(
                ':facId' => $facId,
                ':cliId' => $cliId,
                ':monId' => $monId,
                ':fecha' => $fecha,
                ':subtotal' => $subtotal,
                ':iva' => $iva,
                ':total' => $total,
                ':tipocambio' => $tipocambio
            );

            $sentencia = $this->db->ejecutarAccion("UPDATE facturas SET cli_id=:cliId,
                                                mon_id = :monId, fac_fec = :fecha, fac_sub = :subtotal, fac_iva = :iva, fac_tot = :total,fac_tc=:tipocambio 
                                                WHERE fac_id = :facId", $valoresActualizar);

            if($sentencia) {
                return 'ok';
            } else {
                return 'error';
            }
        }

        public function delete($id)
        {
            $valoresEliminar = array(
                ':facId' => $id,
            );
            $sentencia = $this->db->ejecutarAccion("DELETE FROM facturas WHERE fac_id = :facId", $valoresEliminar);

            if($sentencia) {
              echo 'ok';
            } else {
              echo 'error';
            }
        }

        public function read()
        {
            $query = "SELECT fac_id, f.mon_id, f.cli_id,fac_fec, fac_sub, fac_iva, fac_tot, fac_tc, cli_nombre, mon_abr FROM facturas f INNER JOIN clientes c ON f.cli_id = c.cli_id INNER JOIN monedas m ON f.mon_id = m.mon_id";
            $objFacturas = null;
            foreach ($this->db->consultar($query) as $key => $value) {
                $objFacturas["data"][] = $value;
            }
            return json_encode($objFacturas, JSON_UNESCAPED_UNICODE);
        }
    }
?>
