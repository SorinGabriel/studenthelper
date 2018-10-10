<?php

	include_once '../phplib/rating.php';
	
	$chestionar=$_POST['cid'];
	$nota=$_POST['rate'];
	session_start();
	if (!isset($_SESSION['user']))
		die('Nu esti conectat');
	if ($nota<1 || $nota>10)
		die('Nota trebuie sa fie intre 1 si 10');
	
	if (rateChestionare($chestionar,$_SESSION['user'],$nota))
		echo 'Succes';
	else
		echo 'S-a produs o eroare';


?>
