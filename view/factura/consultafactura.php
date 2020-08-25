<?php require 'view/main/menu.php';
    $menu = new Menu();
    $menu->header('ConsultaFactura', 'Consulta tu factura')
?>
<div class="card-body">
    <table id="tablaFactura" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">
        <thead>
        <tr>
            <th>ID Factura</th>
            <th>Cliente</th>
            <th>Moneda</th>
            <th>Fecha Factura</th>
            <th>Subtotal</th>
            <th>IVA</th>
            <th>Total</th>
            <th>Tipo de cambio</th>
            <th></th>
        </tr>
        </thead>
    </table>
</div>

<!-- Modal Eliminar-->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modallogoutLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de eliminar este registro?
            </div>
            <form method="post" id="formEliminar" name="formEliminar">
                <div class="modal-footer">
                    <input type="hidden" id="idEliminar" name="idEliminar" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnEliminar" name="btnEliminar" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Actualizar-->
<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-labelledby="ModalActualizar" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <h3 class="card-title">Factura <small> &nbsp; (*) Campos requeridos</small></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="formActualizar" id="formActualizar" name="form" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label>Id Factura</label>
                                    <input type="text" class="form-control" id="idfactura" name="idfactura" readonly />
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
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
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6">
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
                            <div class="col-6 col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha Factura (*)</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date("Y-m-d");?>" placeholder="Fecha Factura" required>
                                </div>
                            </div>
                        </div>
                        <hr class="bg-gradient-indigo">
                        <div class="row">
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <label>Subtotal (*)</label>
                                    <input type="number" onkeypress="return calcularTotal();" onblur="return calcularTotal();" class="form-control" id="subtotal" name="subtotal" placeholder="$ Subtotal" required/>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="form-group">
                                    <label>IVA (*)</label>
                                    <input type="number" onkeypress="return calcularTotal();" onblur="return calcularTotal();" class="form-control" id="iva" name="iva" placeholder="IVA" required/>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="form-group">
                                    <label for="rfc">Tipo de cambio(*)</label>
                                    <input type="text" onkeypress="return calcularTotal();" onblur="return calcularTotal();" name="tipocambio" id="tipocambio" class="form-control" maxlength="13" placeholder="Tipo de cambio" value="">
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
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>

    <!-- Modal Consulta-->
    <div class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="ModalConsulta" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Factura</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="formConsulta" id="formConsulta" name="form" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Id Factura</label>
                                        <input type="text" class="form-control" id="idfacturaconsulta" name="idfacturaconsullta" readonly />
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label for="genero">Cliente</label>
                                        <select disabled class="custom-select" name="clienteconsulta" id="clienteconsulta">
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

                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label for="genero">Moneda</label>
                                        <select disabled readonly="" onchange="calcularTotal();" class="custom-select" name="monedaconsulta" id="monedaconsulta">
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
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="fecha">Fecha Factura</label>
                                        <input type="date" readonly name="fechaconsulta" id="fechaconsulta" class="form-control" value="<?php echo date("Y-m-d");?>" placeholder="Fecha Factura" required>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-gradient-indigo" />
                            <div class="row">
                                <div class="card-body col-lg-12">
                                    <table id="tablaFacturaDetalleConsulta" name="tablaFacturaDetalleConsulta" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>ID FacturaDetalle</th>
                                            <th>Concepto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Importe</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <hr class="bg-gradient-green">
                            <div class="row">
                                <div class="col-4 col-md-4">
                                    <div class="form-group">
                                        <label for="rfc">Tipo de cambio</label>
                                        <input type="text" readonly onkeypress="return calcularTotal();" onblur="return calcularTotal();" name="tipocambioconsulta" id="tipocambioconsulta" class="form-control" maxlength="13" placeholder="Tipo de cambio" value="">
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4">
                                    <div class="form-group">
                                        <label>% IVA</label>
                                        <input type="number" readonly onkeypress="return calcularTotal();" onblur="return calcularTotal();" class="form-control" id="ivaconsulta" name="ivaconsulta" placeholder="IVA" required/>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Subtotal</label>
                                        <input type="number" readonly onkeypress="return calcularTotal();" onblur="return calcularTotal();" class="form-control" id="subtotalconsulta" name="subtotalconsulta" placeholder="$ Subtotal" required/>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input type="text" class="form-control" id="totalconsulta" name="totalconsulta" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn btn-danger" id="btnGenerarPDF" name="btnGenerarPDF"><i class="fas fa-file-pdf" type="button">  Generar PDF</i></button>
<!--                            <a class="btn btn-danger" href="--><?php //echo constant('URL').'Factura/GenerarPDF?id='?><!--"><i class="fas fa-file-pdf" type="button">  Generar PDF</i></a>-->
                        </div>
                    </form>
                </div>
            </div>
            </div>
            </div>

<?php $menu->footer() ?>

<script type="text/javascript">
    $(document).ready(function () {
        mostrarRegistros();
        eliminarRegistro();
        enviarFormularioActualizar();
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
    var mostrarRegistros = function () {
        var table = $("#tablaFactura").DataTable({
            ajax: {
                method: "POST",
                url: "<?php echo constant('URL')?>Factura/ReadModel",
            },
            columns: [
                {data: "fac_id"},
                {data: "cli_nombre"},
                {data: "mon_abr"},
                {data: "fac_fec"},
                {data: "fac_sub"},
                {data: "fac_iva"},
                {data: "fac_tot"},
                {data: "fac_tc"},
                {
                    data: null,
                    "defaultContent": "<button class='consulta btn btn-primary' data-toggle='modal' data-target='#modalConsulta'><i class=\"fa fa-eye\"></i></button> " +
                        "<button class='editar btn btn-warning' data-toggle='modal' data-target='#modalActualizar'><i class=\"fa fa-edit\"></i></button> " +
                        "<button class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalEliminar'><i class=\"far fa-trash-alt\"></i></button>"
                }
            ],
            responsive: true,
            language: idiomaDataTable,
            lengthChange: true,
            buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis'],
            dom: 'Bfltip'
        });

        table.buttons().container().appendTo('#tablaFactura_wrapper .col-md-6:eq(0)');
        obtenerdatos(table);
    }
    var obtenerdatos = function (table) {
        $('#tablaFactura tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            console.log("DATA: " + data.fac_id);
            /*MODAL ELIMINAR*/
            var idEliminar = $('#idEliminar').val(data.fac_id);
            /*MODAL ACTUALIZAR*/
            var idfactura = $('#idfactura').val(data.fac_id);
            var cliente = $("#cliente option[value='"+ data.cli_id +"']").attr("selected",true);
            var cliente2 = $("#cliente").val(data.cli_id).trigger('change.select2');
            var moneda = $("#moneda option[value='"+ data.mon_id +"']").attr("selected",true);
            var moneda2 = $("#moneda").val(data.mon_id).trigger('change.select2');
            var fecha = $("#fecha").val(data.fac_fec);
            var subtotal = $("#subtotal").val(data.fac_sub);
            var iva = $("#iva").val(data.fac_iva);
            var total = $("#total").val(data.fac_tot);
            var tipocambio = $("#tipocambio").val(data.fac_tc);
            /*MODAL CONSULTA*/
            var idfactura = $('#idfacturaconsulta').val(data.fac_id);
            var cliente = $("#clienteconsulta option[value='"+ data.cli_id +"']").attr("selected",true);
            var cliente2 = $("#clienteconsulta").val(data.cli_id).trigger('change.select2');
            var moneda = $("#monedaconsulta option[value='"+ data.mon_id +"']").attr("selected",true);
            var moneda2 = $("#monedaconsulta").val(data.mon_id).trigger('change.select2');
            var fecha = $("#fechaconsulta").val(data.fac_fec);
            var subtotal = $("#subtotalconsulta").val(data.fac_sub);
            var iva = $("#ivaconsulta").val(data.fac_iva);
            var total = $("#totalconsulta").val(data.fac_tot);
            var tipocambio = $("#tipocambioconsulta").val(data.fac_tc);

            mostrarRegistrosFacturaDetalle();
            $('#btnGenerarPDF').on('click', function() {
                window.open ("<?php echo constant('URL');?>Factura/GenerarPDF?id=" + idfactura.val(), '_blank');
            });
        });
    }
    var eliminarRegistro = function() {
        $("#btnEliminar").click(function () {
            $.ajax({
                type: "POST",
                url: "<?php echo constant('URL')?>Factura/DeleteModel",
                data: {"idEliminar": $('#idEliminar').val()},
                success: function(data) {
                    if(data == 'ok') {
                        swal(
                            "¡Éxito!",
                            "La factura ha sido eliminada satisfactoriamente",
                            "success"
                        ).then(function() {
                            window.location = "<?php echo constant('URL')?>Factura/Read";
                        });
                    } else {
                        swal(
                            "¡Error!",
                            "Ha ocurrido un error al eliminar la Factura. " + data,
                            "error"
                        );
                    }
                }
            });
        });
    }
    var enviarFormularioActualizar = function () {
        $.validator.setDefaults({
            submitHandler: function () {
                var datos = $('#formActualizar').serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo constant('URL') . 'Factura/updatemodel' ?>",
                    data: datos,
                    success: function(data){
                        if(data == 'ok') {
                            swal(
                                "¡Éxito!",
                                "La Factura quedó modificada de manera correcta",
                                "success"
                            ).then(function() {
                                window.location = "<?php constant('URL') . 'Factura/Read'?>";
                            });
                        } else {
                            swal(
                                "¡Error!",
                                "Ha ocurrido un error al actualizar la Factura. ",
                                "error"
                            );
                        }
                    },
                });
            }
        });
        $('#formActualizar').validate({
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
        document.getElementById('total').value = total;
    }

    var mostrarRegistrosFacturaDetalle = function () {
        var idFactura = $('#idfactura').val();
        //$.ajax({
        //    type: "POST",
        //    url: "<?php //echo constant('URL')?>//Factura/ReadFacDetByIdModel",
        //    data: {"idFactura": idFactura},
        //    success: function (data) {
        //        console.log("DATOS:"  + data);
        //    }
        //});
        var table = $("#tablaFacturaDetalleConsulta").DataTable({
            ajax: {
                method: "POST",
                url: "<?php echo constant('URL')?>Factura/ReadFacDetByIdModel",
                data: {"idFactura": idFactura}
            },
            columns: [
                {data: "fac_det_id"},
                {data: "fac_det_con"},
                {data: "fac_det_can"},
                {data: "fac_det_pun"},
                {data: "fac_det_imp"}
            ],
            responsive: true,
            language: idiomaDataTable,
            bDestroy: true,
            lengthChange: true
            // buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis'],
            // dom: 'Bfltip'
        });

        // table.buttons().container().appendTo('#tablaFacturaDetalleConsulta_wrapper .col-md-6:eq(0)');
    }
</script>