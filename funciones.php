<?php

// CONEXION
//en la variable conecion se considera servidor usuario contraseña y base de datos
$conexion= mysqli_connect("localhost", "root", "", "phptube");

if($conexion==false){ 
	echo "hubo un error al conectarse a la bd";
	die();//truncar
}


//Funcion para subir imagen a la plataforma
//FUNCION GRABAR_IMAGEN
function grabar_imagen($archivo){//recibe por parametro la variable $archivo
  $conexion = $GLOBALS['conexion'];//para poder usar la conexion dentro de una funcion la llamos d manera global

  $msg = "";//declaramos una variabl vacia tipo cadena
  $ruta ="archivos/"; //en esta variable guardamos el nombre de la carpeta donde se guardan las imagenes
  //en la variable $archivo se guarda en namobre de INPUT y el name obtine el nombre de la img
  $ruta_final = $ruta . basename($archivo["archivo"]["name"]); //en 
  $estado_subido = 1; //subido correcto no subido seria 0

  //aca se convierte a minusculas la extencion d la imagen donde pathinfo solicita la informacion de la imagen
  $tipo_de_imagen = strtolower(pathinfo($ruta_final,PATHINFO_EXTENSION));

  //validamos para saber si ya hay un archivo con ese nombre
  if(file_exists($ruta_final)){
  	$msg.= "la imagen ya existe!!.<br>";
  	$estado_subido = 1; //imagen no subida
  }

  //CALIDAMOS EL TAMAÑO DE LA IMAGEN PARA EVITAR BULNERABILIDADES
  if($archivo["archivo"]["size"] > 500000){ //checamos el tamaño maximo
  	$msg.= "la imagen es muy grande. <br>";
  	$estado_subido= 0;
  }

  //validamos para que no se hacepte archivos diferentes a imagenes con la variable $tipo_de_imagen

  if($tipo_de_imagen != "jpg" && $tipo_de_imagen != "png" && $tipo_de_imagen != "jpeg" && $tipo_de_imagen != "gif"){
  	$msg.= "Solo se permiten archivos con extencion jpg, png, jpge, gif. <br>";
  	$estado_subido= 0;
  }

  //validamos el estado de subido
  if($estado_subido==0){
  	$msg.= "esta imagen no puede subirse. <br>";
  	//Si todo esta correcto grabamos la imagen
  }else{
  	if(move_uploaded_file($archivo["archivo"]["tmp_name"], $ruta_final)){
  		$msg.= "la imagen ". basename($archivo["archivo"]["name"]). "ha sido actualizada";
  		 //Y FINALMENTE ACTUALIZAMOS
		  $conexion->query("UPDATE `usuarios` SET `usuarios_imagen` = '".$ruta_final."' WHERE `usuarios_id` = '".$_SESSION['usuarios_id']."' ");
  	}else{
  		$msg.="error parse que su disco duro no graba o su internet esta lento. <br>";
  	}
  }
   return $msg; //para avarque todas las validaciones
 

} 

 //FUNCION PARA CARGAR LA IMAGEN DEL USUARIO Cuando la actualiza

function obtener_imagen_usuario(){
	$conexion = $GLOBALS['conexion']; //llamanos a la conexion

	$consulta = "SELECT `usuarios_imagen` FROM `usuarios` WHERE `usuarios_id` = '".$_SESSION['usuarios_id']."'";
	$resultado = $conexion->query($consulta); //almacenamos en una variable la conexion y le agrgarmos la 												conversion a consulta con query
	$fila = $resultado->fetch_assoc(); //debuelve una posicion de un array fetch_assoc
	
	$ruta=$fila['usuarios_imagen'];//solo opctenemos la ruta de la imagen sin array
	print_r($ruta);
}
//FUNCION PARA ACTUALIZAR LA CONTRASEÑA
function subir_videos($archivo){
	$conexion = $GLOBALS['conexion'];//llamamos a la conexion
	$msg2="";//para los mensajes
	$ruta="archivos/";

	$ruta_final= $ruta .basename($archivo['archivo']['name']);//caturamos la ruta de iamgen
	$estado_subido= 1;//estado responde a uno acetado y 0 no aceptado
	$tipo_video = strtolower(pathinfo($ruta_final,PATHINFO_EXTENSION));

   	if(file_exists($ruta_final)){
  		$msg2.= "El video ya existe!!.<br>";
  		$estado_subido = 1; //imagen no subida
 	 }

  //CALIDAMOS EL TAMAÑO DE LA IMAGEN PARA EVITAR BULNERABILIDADES
  	if($archivo["archivo"]["size"] > 50000000){ //checamos el tamaño maximo
  		$msg2.= "El video es muy grande. <br>";
  		$estado_subido= 0;
  	}

  //validamos para que no se hacepte archivos diferentes a imagenes con la variable $tipo_de_imagen

  	if($tipo_video != "mp4"){
  		$msg2.= "Solo se permiten archivos con extencion MP4. <br>";
  		$estado_subido= 0;
  	}

  //validamos el estado de subido
 	 if($estado_subido==0){
  		$msg2.= "este video no puede subirse. <br>";
  	//Si todo esta correcto grabamos la imagen
  	}else{
	  	  if(move_uploaded_file($archivo["archivo"]["tmp_name"], $ruta_final)){
	  		   $msg2.= "El video ". basename($archivo["archivo"]["name"]). "ha sido actualizado";
	  		 //Y FINALMENTE ACTUALIZAMOS
			     $conexion->query("INSERT INTO `videos` (`videos_ruta`, `videos_usuario_id`) VALUES ('".$ruta_final."', '".$_SESSION['usuarios_id']."') ");
	  	  }else{
	  		 $msg2.="error parse que su disco duro no graba o su internet esta lento. <br>";
	  	  }
  	}
   return $msg2; //para avarque todas las validaciones

}

//Creamos la funcion para insertar el video 
function obtiene_videos(){
  $conexion = $GLOBALS['conexion']; //llamamos a la conexion de forma global
  $resultado = $conexion->query("SELECT * FROM usuarios,videos WHERE usuarios.usuarios_id=videos.videos_usuario_id ");
  $videos= $resultado->fetch_all(MYSQLI_ASSOC);
  //para probar siempre algun array que este funcional
  /**echo "<pre>";
  print_r($videos);
  die();
  **/
  return $videos;
}


?>