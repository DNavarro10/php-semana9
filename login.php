<?php session_start();
/* comprobar seseion*/
if (isset($_SESSION['usuario'])){
	header('Location: index.php');
}

$errores = '';

/* comprobar si los datos an sido enviados*/
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password = hash('sha512' , $password);
	
	try{
		$conexion = new PDO('mysql:host=localhost; dbname=login','root', '');
	} catch (PDOException $e){
		echo "error: " . $e->getMessage();;
	}
	
	/* Verificar si hay usuarios*/
	
	$estado = $conexion ->prepare('
	SELECT * FROM usuarios WHERE usuario = :usuario AND pass = :password'
	);
	
	$estado->execute(array(
		':usuario' =>$usuario,
		':password' =>$password
	));
	
	$resultado = $estado->fetch();
	if($resultado !== false){
		$_SESSION['usuario'] = $usuario;
		header('Location: index.php');
	} else {
		$errores .= '<li> Datos incorrectos</li>';
	}
}


require 'Vistas/login.view.php';
?>