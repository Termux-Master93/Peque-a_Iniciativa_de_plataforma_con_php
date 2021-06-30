<?php
session_start();
$autorizado= $_SESSION['autorizado'];
if($autorizado==false){
  echo "pinche pendejo crees que me vas a Bulnerar";
  echo '<meta http-equiv="refresh" content="1; url=login.php">'; 
  die();
}


//llamamos a la funcion grabar imagen en la base de datos
 require_once('funciones.php');
 echo obtener_imagen_usuario();

 $msg="";//para validaciones de la imagn
 $msg2="";//para validar el cambio de contraseña
 if($_FILES){ //solo se ejecuta si hay un archivo nviado por post en el formulario
  $archivo = $_FILES;
  $msg =grabar_imagen($archivo); //llamamos a la funcion creada en funciones.php y le agregamos su parametro
 }


//Validamos y actualizamos la contraseña
 if(isset($_POST['nueva_password']) && isset($_POST['nueva_password_repite'])){
    $password = strip_tags($_POST['nueva_password']);//strip_tags debuelve el valor que se ingrese en el formulario
    $repite_password = strip_tags($_POST['nueva_password_repite']);
    if($password != $repite_password){
      $msg2.= "Las Contraseñas no considen. <br>";
    }else if(strlen($password) < 8){
      $msg2.="la contraseña debe tener almenos 8 caracteres. <br>";

    }else{//caso contrario incrptamos la cantraseña y la actualizamos
      $password=sha1($password);//
      $conexion->query("UPDATE `usuarios` SET `usuarios_password`   = '".$password."' WHERE `usuarios_id`= '".$_SESSION['usuarios_id']."' ");
        $msg2.="Cambio de Contrasña Exitoso. <br>";
    }

 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPTUBE WEB ELVIS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
  
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">

      </li>

      <!-- Messages Dropdown Menu -->
      

      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>

      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <i style="opacity: .8" class="fas fa-snowman"></i> 
      <span class="brand-text font-weight-light h2">PhpTube Elvis</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo obtener_imagen_usuario();?>" class="img-circle elevation-2" alt="User imagen">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['usuarios_email']?></a>
          <span class="text-white">Ultimo Login:</span>
          <p class="text-white"><?php echo $_SESSION['usuarios_ultimo_login'] ?></p>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Buscar..." aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Principal</li>
          <li class="nav-item menu-open">
            <a href="index.php" class="nav-link active">
              <i class="fas fa-binoculars"></i>
              <p>DESCUBRIR</p>
            </a>
          </li>

           <li class="nav-item menu-open">
            <a href="configuracion.php" class="nav-link">
              <i class="fas fa-users"></i>
              <p>SIGUIENDO</p>
            </a>
          </li> 

          <li class="nav-header">Herramientas</li>

           <li class="nav-item menu-open">
            <a href="configuracion.php" class="nav-link">
              <i class="fa fa-cog"></i>
              <p>CONFIGURACION</p>
            </a>

          </li>  

           <li class="nav-item menu-open">
            <a href="logout.php" class="nav-link">
              <i style="color: #Be252a" class="fas fa-arrow-alt-circle-right"></i>
              <p>SALIR</p>
            </a>
          </li>  


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
<!-- /.col -->
<!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
              <form action="configuracion.php" method="POST">
                <div class="card-body">
                  <label class="h3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cambia Contraseña Recomendado</font></font></label>                  
                  <div class="form-group">
                    <label for="exampleInputPassword1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Contraseña</font></font></label>
                    <input name="nueva_password" type="password" class="form-control" id="exampleInputPassword1">
                  </div>
              
                  <div class="form-group">
                    <label for="exampleInputPassword1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Repite Contraseña</font></font></label>
                    <input name="nueva_password_repite" type="password" class="form-control" id="exampleInputPassword1" >
                  </div>
  
                  <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Actualizar Contraseña</font></font></button>
                </div>
                <p class="text-danger">
                  <?php 
                    if ($msg2 != "") {
                      print_r($msg2);
                    }
                  ?>
                  
                </p>
                </div>
                <!-- /.card-body -->
              </form>

          </div>

          <div class="col-lg-3 col-6">
            <!-- actualizar foto  modelo para cada vex que se necesite enviar archivos php-->
              <form action="configuracion.php" enctype="multipart/form-data" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1" class="h3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Actualiza tu Foto de Perfil</font></font></label>
                  </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Selecciona</font></font></label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input name="archivo" type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Elija el archivo</font></font></label>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Actualizar</font></font></button>

                    <p class="text-danger"> <!--imprimiendo el mensaje de actualizar imagen-->
                      <?php 
                      if($msg != ""){
                        echo $msg;
                      }
                      ?>
                    </p>
                </div>
                </div>
                <!-- /.card-body -->


              </form>
          </div>
          <!-- ./col -->
          <!-- ./col -->
  
          <!-- ./col -->

          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
        
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
         
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="https://termux-Master">PHP TUBE ELVIS</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
