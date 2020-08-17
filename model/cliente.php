<?php

    class Cliente {
        private $cliId;
        private $cliRfc;
        private $cliNombre;

        public function __get($name) {
            return $this->$name;
        }

        public function __set($name, $value) {
            return $this->$name = $value;
        }
    }
?>
