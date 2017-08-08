<?php session_start();

if (isset($_SESSION['usuario'])){
	header('Location: index.php');
}

//revibir datos

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	/* 
		funciones usadas
			filter_var() para limpar valores
			strtolower() transformar a minusculas
			como parametros de filter_var
				FILTER_SANITIZE_STRING
				para evitar injecciones de codigo
	*/
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
	$password = filter_var(strtolower($_POST['password']), FILTER_SANITIZE_STRING);
	$password2 = filter_var(strtolower($_POST['password2']), FILTER_SANITIZE_STRING);
	
	/* comprobar errores*/
	$errores = '';
	
	/* comprobar conexion*/
	if (empty($usuario) or empty($password) or empty($password2)){
		$errores .= '<li>Por favor llenar los datos faltantes</li>';
	} else {
		try{
			$conexion = new PDO('mysql:host=localhost; dbname=login','root', '');
		} catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
		/* verificar si existe usuario
		 	PREPARE para preparar la consulta , :USUARIO por placeholder
		*/
		
		$estado = $conexion->prepare('SELECT * FROM usuarios WHERE usuarios = :usuario LIMIT 1');
		$estado->execute(array(':usuario' => $usuario));
		$resultado = $estado->fetch();
		/* $resultado guarda  O registro de usuario O false*/
		
		if ($resultado != false){
			$errores .= '<li>El usuario ya existe</li>';
		}
		
		/* hash de contraseña = convertir caracteres a x cantidad */
		$password = hash('sha512', $password);
		$password2 = hash('sha512', $password2);
		
		/* comprobar contraseñas */
		if($password != $password2){
			$errores .= '<li>Las contraseñas no son iguales</li>';
		}
	}
	/* si error = '' , no hay errores*/
	if($errores == ''){
		$estado = $conexion->prepare('INSERT INTO usuarios (id, usuario, pass) 
		VALUES (null, :usuario, :pass)');
		
		$estado ->execute(array(
			':usuario'=> $usuario, 
			':pass' => $password
		));
		
		header('Location: login.php');
	}

}

	/* Vista del formulario */
	require 'Vistas/registrate.view.php';
?>