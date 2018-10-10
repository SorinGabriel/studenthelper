<?php

	include_once '../phplib/qa.php';
	include_once '../phplib/usersactions.php';
	
	$id=$_POST['id'];
	session_start();
	$user=$_SESSION['user'];
	
	if (deleteQA($id,$user))
		echo 'Succes';
	else
		echo 'Ceva nu a mers bine';
	
?>
