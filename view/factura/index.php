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
        enviarFormularioInsertar();
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
                        if(data == 'ok') {
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
        document.getElementById('total').value = total;
    }
</script>
