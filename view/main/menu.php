<?php

    class Menu {
        private $activeInicio = "";
        private $activeFactura = "";
        private $activeRegistraFactura = "";
        private $activeConsultaFactura = "";

        public function __construct()
        {
        }

        function header($active, $title)
        {
            if($active == 'ConsultaFactura') {
                $this->activeConsultaFactura = 'active';
                $this->activeFactura = 'active';
            } else if($active == 'FacturaController') {
                $this->activeRegistraFactura = 'active';
                $this->activeFactura = 'active';
            } else if($active == 'Inicio') {
                $this->activeInicio = 'active';
            }
            echo '<!DOCTYPE html>
      <html>
      <head lang="es">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Examen PHP</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="'. constant('URL').'public/img/favicon.png"/>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="'.constant('URL').'public/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
               <!-- Select2 -->
        <link rel="stylesheet" href="'.constant('URL').'public/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="'. constant('URL').'public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="'. constant('URL').'public/css/adminlte.min.css" >
        <link rel="stylesheet" href="'. constant('URL').'public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="'. constant('URL').'public/plugins/datatables-responsive/css/responsive.bootstrap4.css">
        <link rel="stylesheet" href="'. constant('URL').'public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
 
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        
      </head>
      <body class="hold-transition sidebar-mini">
      <!-- Site wrapper -->
      <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <a href="'.constant('URL').'Main" class="nav-link">Inicio</a>
            </li>
          </ul>
          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="'. constant('URL').'public/img/phpimgg.png" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-md-inline"> Administrador </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                  <img src="'. constant('URL').'public/img/phpimgg.png" class="img-circle elevation-2" alt="User Image">
      
                  <p>
                    Temolzin Itzae Roldan Palacios                    
                    <small> Administrador </small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalActualizarPerfil">Perfil</a>
                  <a href="#" class="btn btn-default btn-flat float-right" data-toggle="modal" data-target="#modallogout">Cerrar sesión</a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.navbar -->
      
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
          <!-- Brand Logo -->
          <a href="'.constant('URL').'Main" class="brand-link">
            <img src="'. constant('URL').'public/img/favicon.png"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Examen PHP</span>
          </a>
      
          <!-- Sidebar -->
          <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <div class="image">
                    <img src="'. constant('URL') . 'public/img/phpimgg.png" class="img-circle elevation-2" alt="User Image">
                  </div class="image">
                  <div class="info">
                    <a href="#" class="d-block">Temolzin Roldan</a>
                  </div>
                </div>
                <li class="nav-item">
                  <a href="'.constant('URL').'Main" class="nav-link '.$this->activeInicio.'">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                      Inicio
                    </p>
                  </a>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link '. $this->activeFactura. '">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                      Facturas
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="'.constant('URL').'Factura/Insert" class="nav-link ' .$this->activeRegistraFactura. '">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Registrar Facturas</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="'.constant('URL').'Factura/Read" class="nav-link ' .$this->activeConsultaFactura. '">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Consultar Facturas</p>
                      </a>
                    </li>
                  </ul>
                </li>
                
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>
      
        <!-- Content Wrapper. Contains page content -->
        <div id="contenedorprincipal" name="contenedorprincipal" class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6" id="titulomenu" name="titulomenu">
                  <h1>' . $title . '</h1>
                </div>
                <div class="col-sm-6">
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>
          <!-- Main content -->
          
          <!-- Modal LOGOUT-->
          <div class="modal fade" id="modallogout" tabindex="-1" role="dialog" aria-labelledby="modallogoutLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Cerrar Sesión</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  ¿Estás seguro de salir del sistema?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <a href="'.constant('URL').'Main" class="btn btn-danger">Cerrar sesión</a>
                </div>
              </div>
            </div>
          </div>

          <section class="content">';
        }

        function footer() {
            echo ' </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
          <div class="float-right d-none d-sm-block">
            <b>Software for ExamenPHP Version </b> 1.0
          </div>
          <strong>Copyright &copy; 2020 <a href="http://github.com/temolzin">Temolzin Roldan</a>.</strong> All rights
          reserved.
        </footer>
      
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
      
      <!-- jQuery -->
      <script src="'.constant('URL').'public/plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="'.constant('URL').'public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="'.constant('URL').'public/js/adminlte.min.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="'.constant('URL').'public/js/demo.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <!-- jquery-validation -->
      <script src="'.constant('URL').'public/plugins/jquery-validation/jquery.validate.min.js"></script>
      <script src="'.constant('URL').'public/plugins/jquery-validation/additional-methods.min.js"></script>
      <script src="'.constant('URL').'public/js/validaciones.js"></script>
      <!-- DataTables -->
      <script src="'.constant('URL').'public/plugins/datatables/jquery.dataTables.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
      <!--<script src="'.constant('URL').'public/plugins/jszip/jszip.min.js"></script>-->
      <script src="'.constant('URL').'public/plugins/pdfmake/pdfmake.min.js"></script>
      <script src="'.constant('URL').'public/plugins/pdfmake/vfs_fonts.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
      <script src="'.constant('URL').'public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
      <!-- iCheck for checkboxes and radio inputs -->
      <link rel="stylesheet" href="'.constant('URL').'public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- Select2 -->
      <script src="'.constant('URL').'public/plugins/select2/js/select2.full.min.js"></script>
      

      <!--Código para los SELECT-->
      <script type="text/javascript">
        $(document).ready(function () {
          $(\'.custom-select\').select2();
        });
    
          
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("//").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
      </script>
            
      </body>
      </html>';
        }
    }
