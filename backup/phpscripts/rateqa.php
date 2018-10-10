<?php

	include_once '../phplib/rating.php';
	
	$qa=$_POST['aid'];
	$nota=$_POST['rate'];
	session_start();
	if (!isset($_SESSION['user']))
		die('Nu esti conectat');
	if ($nota<1 || $nota>10)
		die('Nota trebuie sa fie intre 1 si 10');
	
	if (rateQA($qa,$_SESSION['user'],$nota))
		echo 'Succes';
	else
		echo 'S-a produs o eroare';


?>
