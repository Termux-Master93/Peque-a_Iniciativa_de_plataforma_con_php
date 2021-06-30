<?PHP 
  $msg="";
  $cantidad=0;
  $usuarios="";
  //se crean las variables para guardar los datos del usuario, ademas 
  //siben para reprobar el formulario
 
  $email="";
  $password="";
  $repite_password="";

  //datos conexion
  //validamos que todos los inputs no esten vacios
  if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repite_password']) && isset($_POST['de_acuerdo'])){

    if($_POST['email']==""){
      $msg.="Debes ingresar un Correo<br>";
    }
    if($_POST['password']==""){
      $msg.="Debes Ingesar Una Contraseña<br>";
    }
    if($_POST['repite_password']==""){
      $msg.="Repita la Contraseña<br>";
    }

    //imprimimos el valor que se esta resiviendo el input 
    //strip_tags para que me limpie lo que ingrese en el input de manera malintencionada
    $email=strip_tags($_POST['email']);
    $password=strip_tags($_POST['password']);
    $repite_password=strip_tags($_POST['repite_password']);

    //validamos para cuando las contraseñas no considan
    if($password != $repite_password){
      $msg.="Contraseñas no considen<br>";
    }else if(strlen($password)<8){ //el strlen me cuenta los caracteres
      $msg.="La clave debe tener 8 caracteres<br>";
    }else{
      //nos conectamos
      $conexion=mysqli_connect("localhost","root","","phptube");
      if($conexion==false){
        echo "Hubo un error al conectar la DB";
        die();
      }

      $ip=$_SERVER['REMOTE_ADDR'];//se gurad la Ip del usuario que se reguistra
      
      //Verificamos que el email no exita en la base de datos
      $resultado = $conexion->query("SELECT * FROM `usuarios` WHERE usuarios_email = '".$email."'");//cuando el email exista
     $usuario = $resultado->fetch_all(MYSQLI_ASSOC); //este array coje los datos de la consulta        
      $cantidad = count($usuario);//almacenamos la cantidad de valores que se obtienen con la consulta
      

      //Si no hay usuarios con el mismo email
      if($cantidad==0){
          $password=sha1($password);//Incriptamos la contraseña con sha1
          $conexion->query("INSERT INTO `usuarios` (`usuarios_email`, `usuarios_password`, `usuarios_ip`) VALUES ('".$email."', '".$password."', '".$ip."');");
          $msg.="Reguistrado Exitosamente,<br> Ingrese haciendo <a href='login.php'>click Aqui</a><br> ";
        }else{
          $msg.="El Email Ingresado Ya existe";
        }

     

    }

  }
?>  

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>PHP</b>Tube</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Registrate...</p>

      <form action="register.php" method="post">
   
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email;?>">
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
        <div class="input-group mb-3">
          <input type="password" name="repite_password" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" required name="de_acuerdo" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               Acepto <a href="#">Terminos Y Condiciones</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
          </div>
          <!-- /.col -->
        </div>
        <!--para que me aparescan los mensajes -->
       <p style="color: red"><?PHP echo $msg;?></p>
      </form>


      <a href="login.php" class="text-center">Ya tengo una Cuenta...</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
