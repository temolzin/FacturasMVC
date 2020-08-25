<?php require 'view/main/menu.php';
    $menu = new Menu();
    $menu->header('FacturaController','Detalle de Factura')
?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Factura <small> &nbsp; (*) Campos requeridos</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" id="form" name="form" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="form-group">
                                    <label for="genero">Cliente (*)</label>
                                    <select class="custom-select" name="cliente" id="cliente">
                                        <?php
                                            include_once 'model/cliente.php';
                                            foreach ($this->clientes as $row) {
                                                $cliente = new Cliente();
                                                $cliente = $row;
                                                echo '<option value="' . $cliente->cliId . '"> ' . $cliente->cliNombre . ' </option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 col-md-3">
                                <div class="form-group">
                                    <label for="genero">Moneda (*)</label>
                                    <select onchange="calcularTotal();" class="custom-select" name="moneda" id="moneda">
                                        <?php
                                            include_once 'model/moneda.php';
                                            foreach ($this->monedas as $row) {
                                                $moneda = new Moneda();
                                                $moneda = $row;
                                                echo '<option value="' . $moneda->monId . '"> ' . $moneda->monAbr . ' </option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 col-md-3">
                                <div class="form-group">
                                    <label for="fecha">Fecha Factura (*)</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date("Y-m-d");?>" placeholder="Fecha Factura" required>
                                </div>
                            </div>
                        </div>
                        <hr class="bg-gradient-indigo">
                        <div class="card-body">
                            <div class="text-center"><button class="btn btn-primary" type="button" id="addRow" name="addRow">Agregar fila</button></div>
                            <table id="tablaFacturaDetalle" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID FacturaDetalle</th>
                                    <th>Concepto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Importe</th>
                                    <th></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <hr class="bg-gradient-green">
                        <div class="row">
                            <div class="col-4 col-md-4">
                                <div class="form-group">
                                    <label for="rfc">Tipo de cambio(*)</label>
                                    <input type="text" onkeypress="calcularTotal();" onblur="calcularTotal();" name="tipocambio" id="tipocambio" class="form-control" maxlength="13" placeholder="Tipo de cambio" value="">
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <label>IVA (*)</label>
                                    <input type="number" onkeypress="calcularTotal();" onblur="calcularTotal();" class="form-control" id="iva" name="iva" placeholder="IVA" required/>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <label>Subtotal (*)</label>
                                    <input type="number" onchange="calcularTotal();" onblur="calcularTotal();" class="form-control" id="subtotal" name="subtotal" placeholder="$ Subtotal" required/>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label>Total</label>
                                    <input type="text" class="form-control" id="total" name="total" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
<?php $menu->footer();?>
<script type="text/javascript">
    $(document).ready(function () {
        mostrarRegistros();
        enviarFormularioInsertar();
        eliminarFila();
    });
    var idiomaDataTable = {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad"
        }
    };
    var tablaFDetalle = $('#tablaFacturaDetalle').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        language: idiomaDataTable,
    });
    var enviarFormularioInsertar = function () {
        $.validator.setDefaults({
            submitHandler: function () {
                var datos = $('#form').serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo constant('URL') . 'Factura/InsertModel' ?>",
                    data: datos,
                    success: function(data){
                        console.log(data);
                        if(data != 'error') {
                            swal(
                                "¡Éxito!",
                                "La Factura quedó registrada de manera correcta",
                                "success"
                            ).then(function() {
                                window.location = "<?php constant('URL') . 'Factura/Insert'?>";
                            });
                        } else {
                            swal(
                                "¡Error!",
                                "Ha ocurrido un error al registrar la Factura. ",
                                "error"
                            );
                        }
                    },
                });
            }
        });
        $('#form').validate({
            rules: {
                fecha: {
                    required: true
                },
                subtotal: {
                    required: true,
                    number: true
                },
                iva: {
                    required: true,
                    number: true
                },
                tipocambio: {
                    required: true,
                    number: true
                }
            },
            messages: {
                fecha: {
                    required: "Ingresa una fecha"
                },
                subtotal: {
                    required: "Ingresa un subtotal",
                    number: "Ingresa un valor númerico"
                },
                iva: {
                    required: "Ingresa el IVA",
                    number: "Ingresa un valor númerico"
                },
                tipocambio: {
                    required: "Ingresa un Tipo de Cambio",
                    number: "Ingresa un valor númerico"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    }
    function calcularTotal () {
        var moneda = document.getElementById("moneda").value;
        var total = 0;
        var iva = document.getElementById('iva').value;
        var subtotal = document.getElementById('subtotal').value;
        if(moneda == 2) {
            var tipocambio = document.getElementById('tipocambio').value;
            total = (subtotal * iva) * tipocambio;
        } else {
            total = subtotal * iva;
        }
        document.getElementById('total').value = total.toFixed(2);
    }

    function calcularSubTotal(e) {
        var acumulador = 0;
        var nombre_input = e.name;
        var hermanos = 'input[name="' + nombre_input + '"]';
        var input_hermanos = $('#tablaFacturaDetalle').find(hermanos);
        $.each(input_hermanos, function (idx, x) {
            var num = parseInt($(x).val());
            if (!isNaN(num) && num != undefined) //Validamos si está vacío o no es un número para acumular
                acumulador += num;
        });
        alert(acumulador);
    }
    function calculo(e)
    {
        var acumulador = 0;
        var nombre_input = e.name;
        var hermanos = 'input[name="' + nombre_input + '"]';
        var input_hermanos = $('table').find(hermanos);
        $.each(input_hermanos, function(idx, x)
        {
            var num = parseInt($(x).val());
            if (!isNaN(num) && num != undefined) //Validamos si está vacío o no es un número para acumular
                acumulador += num;
        });
}
    var counter = 1;
    var mostrarRegistros = function () {

        $('#addRow').on( 'click', function () {
            tablaFDetalle.row.add( [
                '<input type="text" value="'+counter+'" class="form-control" name="facDetId[]" id="facDetId" readonly>',
                '<input type="text" class="form-control" name="concepto[]" placeholder="Concepto" id="concepto">',
                '<input type="number" class="form-control" value="1" name="cantidad[]" placeholder="Cantidad" id="cantidad" onkeyup="calcularSubTotal(this); calcularImporte();">',
                '<input type="number" class="precioUnitario form-control" placeholder="$ Precio Unitario" name="precioUnitario[]" id="precioUnitario" onkeyup="calcularSubTotal(this); calcularImporte();">',
                '<input type="text" value="1" class="form-control" name="importe[]" id="importe" placeholder="$ Importe" readonly onchange="calcularSubTotal(this)">',
                '<button type="button" onclick="eliminarFila(this);" class="eliminar btn btn-danger" id="btnEliminar" name="btnEliminar[]" data-toggle="modal" data-target="#modalEliminar"><i class="far fa-trash-alt"></i></button>'
            ] ).draw( false );

            counter++;
        } );

        // Automatically add a first row of data
        $('#addRow').click();
    }

    function calcularImporte() {
            var importe = 0;
            // var precioUnitario = 'input[name="precioUnitario"]';
            // var cantidad = 'input[name="cantidad"]';
            var precioUnitario = 'input[name="precioUnitario"]';
            var pU = $('#tablaFacturaDetalle').find(precioUnitario);
            // var precioUnitario = tablaFDetalle.$('input, select').serialize();
            // var importe = 'input[name="' + importe + '"]';
            importe = precioUnitario * cantidad;
            // var input_hermanos = $('#tablaFacturaDetalle').find(hermanos);
            // $.each(input_hermanos, function (idx, x) {
            //     var num = parseInt($(x).val());
            //     if (!isNaN(num) && num != undefined) //Validamos si está vacío o no es un número para acumular
            //         acumulador += num;
            // });
            alert('IMPORTE: ' + pU);
    }
    function eliminarFila( ) {

        tablaFDetalle.on('click', '.eliminar', function () {
            tablaFDetalle.row( $(this).parents('tr')).remove().draw();
        });
        //tablaFDetalle.on('click', '.btn-info', function () { $(this).parent().parent().remove(); });
    }
    var obtenerdatos = function (table) {
        $('#tablaFacturaDetalle tbody').on('change', 'tr', function() {
            var data = table.row(this).data();
            console.log("DATA: " + data[3].element);
            // var idEliminar = $('#idEliminar').val(data.fac_id);
            // var idfactura = $('#idfactura').val(data.fac_id);
            // var cliente = $("#cliente option[value='"+ data.cli_id +"']").attr("selected",true);
            // var cliente2 = $("#cliente").val(data.cli_id).trigger('change.select2');
            // var moneda = $("#moneda option[value='"+ data.mon_id +"']").attr("selected",true);
            // var moneda2 = $("#moneda").val(data.mon_id).trigger('change.select2');
            // var fecha = $("#fecha").val(data.fac_fec);
            // var subtotal = $("#subtotal").val(data.fac_sub);
            // var iva = $("#iva").val(data.fac_iva);
            // var total = $("#total").val(data.fac_tot);
            // var tipocambio = $("#tipocambio").val(data.fac_tc);
        });
    }
</script>
