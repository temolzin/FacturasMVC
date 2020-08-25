<?php require 'view/main/menu.php';
    $menu = new Menu();
    $menu->header('FacturaController','Registra tu factura')
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
                                    <label for="rfc">$ Tipo de cambio(*)</label>
                                    <input type="number" onkeypress="calcularTotal();" onkeyup="calcularTotal();" onblur="calcularTotal();" onchange="calcularTotal()" name="tipocambio" id="tipocambio" class="form-control" maxlength="13" placeholder="Tipo de cambio" value="">
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <label>% IVA(*)</label>
                                    <input type="number" onkeypress="calcularTotal();" onkeyup="calcularTotal();" onblur="calcularTotal();" onchange="calcularTotal();" class="form-control" id="iva" name="iva" placeholder="IVA" required/>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <label>$ Subtotal (*)</label>
                                    <input type="number" readonly class="form-control" onchange="calcularTotal();" id="subtotal" name="subtotal" placeholder="$ Subtotal" required/>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label>$ Total</label>
                                    <input type="text" class="form-control" id="total" name="total" placeholder="$ Total" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" onclick="calcularSubTotal(); calcularTotal();" class="btn btn-primary">Registrar</button>
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
        var subtotal = document.getElementById('subtotal').value;
        var moneda = document.getElementById("moneda").value;
        var total = 0;
        var iva = document.getElementById('iva').value;

        if(moneda == 2) {
            var tipocambio = document.getElementById('tipocambio').value;
            total = (subtotal * iva) * tipocambio;
        } else {
            total = subtotal * iva;
        }
        document.getElementById('total').value = total.toFixed(2);
    }

    function calcularSubTotal() {
        var acumulador = 0;
        // var nombre_input = e.name;
        // var hermanos = 'input[name="' + nombre_input + '"]';
        var hermanos = 'input[name="importe[]"]';
        var input_hermanos = $('#tablaFacturaDetalle').find(hermanos);
        $.each(input_hermanos, function (idx, x) {
            var num = parseFloat($(x).val());
            if (!isNaN(num) && num != undefined) //Validamos si está vacío o no es un número para acumular
                acumulador += num;
        });
        document.getElementById('subtotal').value = acumulador.toFixed(2);
    }

    var counter = 1;
    var mostrarRegistros = function () {
        $('#addRow').on( 'click', function () {
            tablaFDetalle.row.add( [
                '<input type="text" value="'+counter+'" class="form-control" name="facDetId[]" id="facDetId" readonly>',
                '<input type="text" class="form-control" name="concepto[]" placeholder="Concepto" id="concepto">',
                '<input type="number" class="form-control" value="1" name="cantidad[]" placeholder="Cantidad" id="cantidad'+counter+'" onblur="calcularSubTotal(); calcularTotal();" onchange="calcularTotal(); calcularSubTotal(); calcularImporte('+counter+');" onkeyup="calcularTotal(); calcularSubTotal(); calcularImporte('+counter+');">',
                '<input type="number" class="precioUnitario form-control" placeholder="$ Precio Unitario" name="precioUnitario[]" onblur="calcularSubTotal(); calcularTotal();" id="precioUnitario'+counter+'" onkeyup="calcularTotal(); calcularSubTotal(); calcularImporte('+counter+');">',
                '<input type="text" value="0" class="form-control" name="importe[]" id="importe'+counter+'" placeholder="$ Importe" readonly onchange="calcularSubTotal(); calcularTotal();">',
                '<button type="button" onclick="eliminarFila(this);" class="eliminar btn btn-danger" id="btnEliminar" name="btnEliminar[]" data-toggle="modal" data-target="#modalEliminar"><i class="far fa-trash-alt"></i></button>'
            ] ).draw( false );

            counter++;
        } );

        // Automatically add a first row of data
        $('#addRow').click();
    }

    /*
    * Función para calcular el importe por fila del datatable*/
    function calcularImporte(num) {
            var preciooUnitario = $("#precioUnitario"+num).val();
            var cantidad = $("#cantidad"+num).val();
            var total = preciooUnitario * cantidad;
            $("#importe"+num).val(total.toFixed(2));
            // document.getElementById("importe"+num).value = total;
    }
    function eliminarFila( ) {

        tablaFDetalle.on('click', '.eliminar', function () {
            tablaFDetalle.row( $(this).parents('tr')).remove().draw();
        });
        //tablaFDetalle.on('click', '.btn-info', function () { $(this).parent().parent().remove(); });
    }
</script>
