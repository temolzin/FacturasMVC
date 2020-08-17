<?php
	/**
	 * 
	 */
	class Factura extends Controller
	{
		function __construct()
		{
			parent::__construct();;
			//Se carga el objetos monedas en la vista
            $this->loadModel('moneda');
            $monedas = $this->consultarMoneda();
            $this->view->monedas = $monedas;
            //Se carga el objclientes en la vista
            $this->loadModel('cliente');
            $clientes = $this->consultarCliente();
            $this->view->clientes = $clientes;

		}

		function read() {
            $this->view->render('factura/consultafactura');
        }

        function insert() {
            $this->view->render('factura/index');
        }

        function readmodel() {
		    $facturaModel = new FacturaModel();
		    echo $facturaModel->read();
        }

		function insertmodel() {
            $cliente = $_POST['cliente'];
            $moneda = $_POST['moneda'];
            $fecha = $_POST['fecha'];
            $subtotal = $_POST['subtotal'];
            $iva = $_POST['iva'];
            $total = $_POST['total'];
            $tipocambio = $_POST['tipocambio'];
            $data = array(
                'cliId' => $cliente,
                'monId' => $moneda,
                'fecha' => $fecha,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'tipocambio' => $tipocambio,
            );
            $facturaModel = new FacturaModel();
            echo $facturaModel->insert($data);
        }
        function updatemodel() {
            $idfactura = $_POST['idfactura'];
            $cliente = $_POST['cliente'];
            $moneda = $_POST['moneda'];
            $fecha = $_POST['fecha'];
            $subtotal = $_POST['subtotal'];
            $iva = $_POST['iva'];
            $total = $_POST['total'];
            $tipocambio = $_POST['tipocambio'];
            $data = array(
                'facId' => $idfactura,
                'cliId' => $cliente,
                'monId' => $moneda,
                'fecha' => $fecha,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'tipocambio' => $tipocambio
            );
            $facturaModel = new FacturaModel();
            echo $facturaModel->update($data);
        }
        function deletemodel() {
		    $idEliminar = $_POST['idEliminar'];
		    $facturaModel = new FacturaModel();
		    echo $facturaModel->delete($idEliminar);
        }

        function consultarMoneda() {
		    $moneda = new MonedaModel();
		    return $moneda->read();
        }

        function consultarCliente() {
		    $cliente = new ClienteModel();
		    return $cliente->read();
        }
	}
?>