<?php
    class FacturaDetalleModel extends Model implements CRUD {
        public function __construct()
        {
            parent::__construct();
        }

        public function insert($data) {
            $factura = new FacturaModel();
            $facId = $factura->readMax();
            $facdetId = $data['fac_det_id'];
            $cantidad = $data['cantidad'];
            $precioUnitario = $data['precioUnitario'];
            $importe = $data['importe'];
            $concepto = $data['concepto'];

            $valoresInsertar = array(
                ':facId' => $facId,
                ':facdetId' => $facdetId,
                ':cantidad' => $cantidad,
                ':precioUnitario' => $precioUnitario,
                ':importe' => $importe,
                ':concepto' => $concepto
            );

            $sentencia = $this->db->ejecutarAccion("INSERT INTO facturas_detalle VALUES (:facId, :facdetId, :cantidad, :precioUnitario, :importe, :concepto)", $valoresInsertar);

            if($sentencia) {
                return 'ok';
            } else {
                return 'error';
            }
        }

        public function update($data)
        {
            $facId = $data['facId'];
            $facdetId = $data['fac_det_id'];
            $cantidad = $data['cantidad'];
            $precioUnitario = $data['precioUnitario'];
            $importe = $data['importe'];
            $concepto = $data['concepto'];

            $valoresActualizar = array(
                ':facId' => $facId,
                ':facdetId' => $facdetId,
                ':cantidad' => $cantidad,
                ':precioUnitario' => $precioUnitario,
                ':importe' => $importe,
                ':concepto' => $concepto
            );

            $sentencia = $this->db->ejecutarAccion("UPDATE facturas_detalle SET fac_det_can = :cantidad,fac_det_pun = :precioUnitario, fac_det_imp = :importe, fac_det_con = :concepto WHERE fac_id = :facId and fac_det_id = :facdetId", $valoresActualizar);

            if($sentencia) {
                return 'ok';
            } else {
                return 'error';
            }
        }

        public function deletebyidfacandidfacdet($idFac, $idFacDet)
        {
            $valoresEliminar = array(
                ':facId' => $idFac,
                ':facdetId' => $idFacDet
            );
            $sentencia = $this->db->ejecutarAccion("DELETE FROM facturas_detalle WHERE fac_id = :facId AND fac_det_id = :facdetId", $valoresEliminar);

            if($sentencia) {
              echo 'ok';
            } else {
              echo 'error';
            }
        }

        public function delete($idFac)
        {
            $valoresEliminar = array(
                ':facId' => $idFac
            );
            $sentencia = $this->db->ejecutarAccion("DELETE FROM facturas_detalle WHERE fac_id = :facId", $valoresEliminar);

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

        public function readbyidfactura($id)
        {
            $query = "SELECT * FROM facturas_detalle WHERE fac_id = " . $id;
            $objFacturas = null;
            foreach ($this->db->consultar($query) as $key => $value) {
                $objFacturas["data"][] = $value;
            }
            return json_encode($objFacturas, JSON_UNESCAPED_UNICODE);
        }

        public function readbyidfacturareporte($id)
        {
            $query = "SELECT * FROM facturas_detalle WHERE fac_id = " . $id;
            $objFacturas = null;
            foreach ($this->db->consultar($query) as $key => $value) {
                $objFacturas[] = $value;
            }
            return $objFacturas;
        }

    }
?>
