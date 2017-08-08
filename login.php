<?php 
/* comprobar seseion*/

if(isset($_SESSION['usuario'])){
	header('login.php');
}
	$usuario = 'Diego';
	sha1($usuario);
	// resultado Sha1() = 1b47e87d02781e58a171f3221a7e4c032e67f2d0
	$contra = '123';
	sha1($contra);
	// resultado Sha1() = 40bd001563085fc35165329ea1ff5c5ecbdbbeef
	
	$errores = '';


	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		
		session_start();
		$intentos = 0;
		$contador = $intentos;
		
		$user = $_POST['usuario'];
		$pass = $_POST['password'];
		
		if($intentos = 5){
			header('url: www.uned.ac.cr');
			
		
		}elseif(empty($user) or empty($pass)){
			$errores .= '<li>Por favor llenar los datos faltantes</li>';
			
			$intentos = $intentos+1;
		
		} elseif($user == sha1($usuario) and $pass == sha1($contra )){
			
			header('Location: http://www.uned.ac.cr/');
		
		} 
		
		
	
	}


	require 'Vistas/login.view.php';

?>