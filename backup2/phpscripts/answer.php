<?php

	include_once '../phplib/qa.php';
	include_once '../phplib/usersactions.php';
	include_once '../phplib/censorship.php';
	
	$mesaj=$_POST['comentariu'];
	$grup=$_POST['grup'];

	session_start();
	if (!isset($_SESSION['user']))
		die('Nu esti conectat');
	
	$test=explode(" ",$mesaj);
	if (count($test)<=3)
		echo 'Mesajul trebuie sa contina minim 4 cuvinte';
	else
	{
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
			if (replyQA($grup,$mesaj,$user))
				echo 'Raspunsul a fost adaugat';
			else
				echo 'S-a produs o eroare';
		}
	}

?>
