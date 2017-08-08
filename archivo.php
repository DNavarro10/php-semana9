<?php  
 // mae usted lo acomoda a como usted le sirve pero esto es la base de como deberia funcionar, no lo pude probar porque el playo de mi hermano no me deja.
$intentos=0;
$contra_encript=sha1('123');
$usuario_encript=sha1('diego');
$intentos=0;
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
	$user=sha1($_POST['usuario']);
	$contra=sha1($_POST['contrasena']);

	if ($user = $usuario_encript && $contra = $contra_encript) {
		session_start();
		$_SESSION['user']=$_POST['usuario'];
		$user_login=$_SESSION['user'];
		$intentos=0;
		header("location: contenido.php");
		}else{
			$intentos++;
		echo "Error en el login. Informacion no esta en la base de datos";
		if($intentos===5){
			header("location: error.php");
		}
	}

}else{
	echo 'todos los campos son requeridos';
}



?>