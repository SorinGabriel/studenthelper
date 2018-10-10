<?php

	include_once '../phplib/chestionare.php';
	include_once '../phplib/usersactions.php';
	
	$idchestionar=$_POST['idchestionar'];
	$corecte=$_POST['corecte'];
	$total=$_POST['total'];
	
	session_start();
	$user=getUserId($_SESSION['user']);
	
	if (registerResults($idchestionar,$user,$corecte,$total))
		echo 'Succes';
	else
		echo 'Ceva nu a decurs cum trebuie';
		
?>