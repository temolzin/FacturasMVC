<?php

    class FacturaDetalle {
        private $facId;
        private $facDetId;
        private $cantidad;
        private $precioUnitario;
        private $importe;
        private $concepto;

        public function __get($name) {
            return $this->$name;
        }

        public function __set($name, $value) {
            return $this->$name = $value;
        }
    }
?>
