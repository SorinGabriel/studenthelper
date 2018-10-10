<?php

	include_once '../phplib/articles.php';
	include_once '../phplib/usersactions.php';
	include_once '../phplib/censorship.php';

	$comment=$_POST['comentariu'];
	$articol=$_POST['articol'];
	session_start();
	if (!isset($_SESSION['user']))
		die('Nu esti conectat');
	
	if (strlen($comment)>65535)
		die("Textul este prea lung");
	
	$test=explode(" ",$comment);
	$cenzura=new censorship();
	$aux=true;
	for ($i=0;$i<count($test);$i++)
		if ($cenzura->aprove($test[$i])===false)
			$aux=false;
	if ($aux===false)
		echo 'Mesajul contine cuvinte interzise';
	else
	{
		$user=getUserId($_SESSION['user']);
		if (postComment($user,$comment,$articol))
			echo 'Comentariul a fost adaugat';
		else
			echo 'S-a produs o eroare';
	}

?>
