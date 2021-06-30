<?php
session_start();//habilitmos variables de seccion
$_SESSION['autorizado']=false;//declaramos variable de seccion

$msg="";
$email="";

if (isset($_POST['email']) && isset($_POST['password'])) {
  if($_POST['email']==""){
    $msg.="Ingrese su Correo Porfavor";
  }else if ($_POST['password']=="") {
    $msg.= "Ingrese Contraseña Porfavor";
  }else{
    $email =strip_tags($_POST['email']);//se recibe el valor ya validado y ingresado en el input
    $password=sha1(strip_tags($_POST['password']));//incrptamos lo que resivimos

    $conexion= mysqli_connect("localhost", "root", "", "phptube");
    if($conexion==false){
      echo "Error al conectar a phptube";
      die(); //truncar
    }

    $resultado=$conexion->query("SELECT * FROM `usuarios` WHERE `usuarios_email`='".$email."' AND `usuarios_password`='".$password."' ");
    $usuario=$resultado->fetch_all(MYSQLI_ASSOC);//MYSQLI_ASSOC debuelve todas las filas del array

      //alamaceamos valores publicos en array bidemencional
    $_SESSION['usuarios_id'] = $usuario[0] ['usuarios_id'];
    $_SESSION['usuarios_email'] = $usuario[0] ['usuarios_email'];
    $_SESSION['usuarios_ultimo_login'] = $usuario[0] ['usuarios_ultimo_login'];


    $cantidad=count($usuario);//si aca se debuelve uno con considencia email y password lo dejamos pasar
    if($cantidad==1){
      $ultimo_login=date("y-m-d H:i:s");//ultimo logim año mes dia hora y minutos date("y-m-d H:i:s")

      $resultado= $conexion->query(" UPDATE `usuarios` SET `usuarios_ultimo_login`='".$ultimo_login."' WHERE  `usuarios_email`='".$email."' ");
        $msg.="Bienbenido";
        $_SESSION['autorizado']=true;//tiene que ser true siempre
        echo '<meta http-equiv="refresh" content="1; url=index.php">';
    }else{
      $msg="Axceso Dnengado";
      $_SESSION['atorizado']=false;
    }

  }
  
}



?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>PHP</b>Tube</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>"> <!--en el value se repobla el email-->
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </div>
          <p style="color: red"><?php echo $msg;?></p>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">Olvide de mi Contraseña</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Registrar una Cuenta.</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
