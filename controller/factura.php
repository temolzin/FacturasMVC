<?php
	/**
	 * 
	 */
    require_once 'public/libs/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

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

            $this->loadModel('facturadetalle');
            $facturaDetalleModel = new FacturaDetalleModel();
            for($i = 0; $i < sizeof($_POST['concepto']); $i++){
                $concepto = $_POST['concepto'][$i];
                $importe = $_POST['importe'][$i];
                $precioUnitario = $_POST['precioUnitario'][$i];
                $cantidad = $_POST['cantidad'][$i];
                $facDetId = $_POST['facDetId'][$i];
                $dataDetalle = array(
                    'fac_det_id' => $facDetId,
                    'cantidad' => $cantidad,
                    'precioUnitario' => $precioUnitario,
                    'importe' => $importe,
                    'concepto' => $concepto
                );
                echo $facturaDetalleModel->insert($dataDetalle);
            }
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

        function readFacDetByIdModel() {
		    $idFactura = $_POST['idFactura'];
            $this->loadModel('facturadetalle');
		    $facturaDetalle = new FacturaDetalleModel();
		    echo $facturaDetalle->readbyidfactura($idFactura);
        }

        function generarPDF() {
            date_default_timezone_set('America/Mexico_City');
		    $idFactura = $_REQUEST['id'];
            //  $nombreCompletoCliente = $_POST[''];
            //  $nombre  = $_POST[''];
            //Se pone setLocale es_MX para traducir el día y el mes a español, pero la fecha no funciona AM/PM
            setlocale(LC_ALL, 'es_MX.UTF-8');
            $horaActual = strftime("%I:%M:%S %p");
            //Se establece SetLocale Spanish para que funcione AM/PM
            setlocale(LC_ALL, 'spanish');
            $fechaActual = strftime("%A, %d de %B de %Y");
            $factura = new FacturaModel();
            $objFactura = $factura->readbyid($idFactura);

            $this->loadModel('facturadetalle');
            $facturaDetalle = new FacturaDetalleModel();
            $arrayFacturasDetalle = $facturaDetalle->readbyidfacturareporte($idFactura);

            $html = '
              <!DOCTYPE html>
              <html lang="en">
                <head>
                  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                  <title>Factura: '.$idFactura.'</title>
                  <link rel="stylesheet" href="'.constant('URL').'public/css/pdfFactura.css" media="all" />
                </head>
                <body>
                  <header class="clearfix">
                    <div id="logo">
                      <!--<img src="'.constant('URL').'public/img/phpimgg.png">-->
                    </div>
                    <div id="company">
                      <h2 class="name">ExamenPHP</h2>
                      <div></div>
                      <div>55-35-09-29-65</div>
                      <div><a href="mailto:temolzin@hotmail.com">temolzin@hotmail.com</a></div>
                    </div>
                    </div>
                  </header>
                  <main>
                    <div id="details" class="clearfix">
                      <div id="client">
                        <div class="to">Cliente:</div>
                        <h2 class="name">'.$objFactura['cli_nombre'].'</h2>
                        <div class="address">RFC: '.$objFactura['cli_rfc'].'</div>
                        <div class="address">Fecha Factura: '.$objFactura['fac_fec'].'</div>
                      </div>
                      <div id="invoice">
                        <h1>Factura: '.$idFactura.'</h1>
        <!--                <div class="date">Date of Invoice: 01/06/2014</div>-->
                        <div class="date">Fecha de impresión: ' .$fechaActual . ', ' .$horaActual . '</div>
                      </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                      <thead>
                        <tr>
                          <th class="no">#</th>
                          <th class="deschead">Concepto</th>
                          <th class="unithead">Cantidad</th>
                          <th class="qtyhead">Precio Unitario</th>
                          <th class="totalhead">Importe</th>
                        </tr>
                      </thead>
                      <tbody>';
                            foreach ($arrayFacturasDetalle as $value) {
                                $html.= "<tr>";
                                $html.= "<td class='no'>" . $value['fac_det_id'] . "</td>";
                                $html.= "<td class='desc'>" . $value['fac_det_con'] . "</td>";
                                $html.= "<td class='unit'> " . $value['fac_det_can'] . "</td>";
                                $html.= "<td class='qty'> $" . $value['fac_det_pun'] . "</td>";
                                $html.= "<td class='total'> $" . $value['fac_det_imp'] . "</td>";
                                $html.= "</tr>";
                            }
                $html .= '
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2"></td>
                          <td colspan="2">SUBTOTAL</td>
                          <td>'.$objFactura['fac_sub'].'</td>
                        </tr>
                        <tr>
                          <td colspan="2"></td>
                          <td colspan="2">IVA %</td>
                          <td>'.$objFactura['fac_iva'].'</td>
                        </tr>                       
                        <tr>
                          <td colspan="2"></td>
                          <td colspan="2">MONEDA</td>
                          <td>'.$objFactura['mon_abr'].'</td>
                        </tr>                        
                        <tr>
                          <td colspan="2"></td>
                          <td colspan="2">TIPO DE CAMBIO</td>
                          <td>'.$objFactura['fac_tc'].'</td>
                        </tr>
                        <tr>
                          <td colspan="2"></td>
                          <td colspan="2">TOTAL</td>
                          <td>'.$objFactura['fac_tot'].'</td>
                        </tr> 
                      </tfoot>
                    </table>
        <!--            <div id="thanks">Thank you!</div>-->
        <!--            <div id="notices">
                      <div>Nota:</div>
                      <div class="notice">El estado de cuenta fue generado por: </div>
                    </div>-->
                  </main>
                  <footer>
                    Factura generada por Temolziin Roldan Copyright &copy; 2020 <a href="#">Temolzin Roldan</a> All rights reserved.
                  </footer>
                </body>
              </html>';

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html, "UTF-8");
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // add the header
            $canvas = $dompdf->get_canvas();
            $font = $dompdf->getFontMetrics()->getFont("Arial", "");

            // the same call as in my previous example
            $canvas->page_text(490, 792, "Página {PAGE_NUM} de {PAGE_COUNT}",
                $font, 12, array(0,0,0));
            $nombreArchivo = "Factura".$idFactura.".pdf";
            $dompdf->stream($nombreArchivo);
        }
	}
?>