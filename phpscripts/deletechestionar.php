<?php

	include_once '../phplib/chestionare.php';
	
	$id=$_POST['cid'];
	session_start();
	$uname=$_SESSION['user'];
	
	if (deleteChestionar($id,$uname))
		echo 'Succes';
	else 
		echo 'Ceva nu a mers bine';
	
?>