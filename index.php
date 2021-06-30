<?php
session_start();
require_once('funciones.php');//llamamos al documento deonde se encuentran las funciones
$autorizado= $_SESSION['autorizado'];
if($autorizado==false){
  echo "pinche pendejo crees que me vas a Bulnerar";
  echo '<meta http-equiv="refresh" content="1; url=login.php">';
  die();
}

$msg="";
$msg2="";

if($_FILES){
  $archivo= $_FILES;
  $msg2=subir_videos($archivo);
}

$videos = obtiene_videos();

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
      <li class="dropdown user user-menu">
          <form action="index.php" enctype="multipart/form-data" method="post">
            <input name="archivo" type="file" class="pull-left" >
             <button type="submit" class="btn btn-primary mt-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Actualizar Video</font></font></button>

              <p class="text-danger"> <!--imprimiendo el mensaje de actualizar imagen-->
                  <?php 
                    if($msg2 != ""){
                     echo $msg2;
                    }
                  ?>
             </p>
                  
          </form>
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
          <img src="<?php echo obtener_imagen_usuario();?>" class="img-circle elevation-2" alt="User Image">
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

  <!-- Contenido del video que se va mostrar almacenado en un bucle para que se incremente solito cuando el usuario ingrese mas videos-->
    <div class="content-wrapper">
  <?php foreach ($videos as $video) { ?> 
  
  
      <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-md-8">
                <!-- Box Comment -->
                <div class="card card-widget">
                  <div class="card-header">
                    <div class="user-block">
                      <img class="img-circle" src="<?php echo $video['usuarios_imagen']; ?>" alt="User Image">
                      <span class="username"><a href="#"><?php echo $video['usuarios_email']; ?></a></span>
                      <span class="description">Publicacion: <?php echo $video['videos_fecha'] ?></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" title="Mark as read">
                        <i class="far fa-circle"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <video controls style="width: 100%">
                      <source src="<?php echo $video['videos_ruta']; ?>" type="video/mp4">
                    </video>

                    <p>I took this photo this morning. What do you guys think?</p>
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                    <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
                    <span class="float-right text-muted">127 likes - 3 comments</span>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer card-comments">
                    <div class="card-comment">
                      <!-- User image -->
                      <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image">

                      <div class="comment-text">
                        <span class="username">
                          Maria Gonzales
                          <span class="text-muted float-right">8:03 PM Today</span>
                        </span><!-- /.username -->
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                      </div>
                      <!-- /.comment-text -->
                    </div>
                    <!-- /.card-comment -->
                    <div class="card-comment">
                      <!-- User image -->
                      <img class="img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="User Image">

                      <div class="comment-text">
                        <span class="username">
                          Luna Stark
                          <span class="text-muted float-right">8:03 PM Today</span>
                        </span><!-- /.username -->
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                      </div>
                      <!-- /.comment-text -->
                    </div>
                    <!-- /.card-comment -->
                  </div>
                  <!-- /.card-footer -->
                  <div class="card-footer">
                    <form action="#" method="post">
                      <img class="img-fluid img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="Alt Text">
                      <!-- .img-push is used to add margin to elements next to floating images -->
                      <div class="img-push">
                        <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                      </div>
                    </form>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>  
    
    <!-- /.content-header -->
  <?php } ?>  
  </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
    
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
  
          </div>
          <!-- ./col -->
  
          <!-- ./col -->

          <!-- ./col -->
        </div>

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
