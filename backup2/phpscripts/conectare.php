<?php

	include_once '../phplib/usersactions.php';
	
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	
	if (authentification($user,$pass))
	{
		newsession($user,$pass);
		die("Te-ai conectat cu succes");
	}
	else
		die("Date incorecte");
?>