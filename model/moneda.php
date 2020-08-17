<?php

    class Moneda {
        private $monId;
        private $monAbr;
        private $monNombre;

        public function __get($name) {
            return $this->$name;
        }

        public function __set($name, $value) {
            return $this->$name = $value;
        }
    }
?>
