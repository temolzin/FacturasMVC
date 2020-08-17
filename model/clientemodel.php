<?php
    class ClienteModel extends Model implements CRUD {
        public function __construct()
        {
            parent::__construct();
        }

        public function insert($datos) {
            //$this->db->conectar()
            $query = $this->db->conectar()->prepare('INSERT INTO ALUMNO (MATRICULA, NOMBRE, APELLIDO) values (:matricula, :nombre, :apellido)');
            $query->execute(['matricula' => $datos['matricula'], 'nombre' => $datos['nombre'], 'apellido' => $datos['apellido']]);
            echo 'INSERTAR DATOS NUEVO';
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
            $query = "SELECT * FROM clientes";
            $objClientes = [];
            $objCliente = null;
            foreach ($this->db->consultar($query) as $key => $value) {
                $objCliente = new Moneda();
                $objCliente->cliId = $value['cli_id'];
                $objCliente->cliRfc = $value['cli_rfc'];
                $objCliente->cliNombre = $value['cli_nombre'];
                array_push($objClientes, $objCliente);
            }
            return $objClientes;
        }
    }
?>
