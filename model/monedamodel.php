<?php
    require 'moneda.php';
    class MonedaModel extends Model implements CRUD {
        public function __construct()
        {
            parent::__construct();
        }

        public function insert($datos) {

        }

        public function update($obj)
        {
            // TODO: Implement update() method.
        }

        public function delete($id)
        {
            // TODO: Implement delete() method.
        }

        public function read()
        {
            $query = "SELECT * FROM monedas";
            $objMonedas = [];
            $objMoneda = null;
            foreach ($this->db->consultar($query) as $key => $value) {
                $objMoneda = new Moneda();
                $objMoneda->monId = $value['mon_id'];
                $objMoneda->monAbr = $value['mon_abr'];
                $objMoneda->monNombre = $value['mon_nombre'];
                array_push($objMonedas, $objMoneda);
            }
            return $objMonedas;
        }
    }
?>
