<?php

	include '../phplib/articles.php';
	include_once '../phplib/censorship.php';
	include_once '../phplib/usersactions.php';

	$titlu=$_POST['titlu'];
	$continut=$_POST['continut'];
	
	//Prelucrare text
	$pre=explode(PHP_EOL,$continut);
	$continut=implode("<br>",$pre);

	$cenzura=new censorship();
	$test=explode(" ",$continut);
	$test2=explode(" ",$titlu);
	
	$aux=true;
	$aux2=true;
	
	for ($i=0;$i<count($test);$i++)
		if ($cenzura->aprove($test[$i])===false)
			$aux=false;
			
	for ($i=0;$i<count($test2);$i++)
		if ($cenzura->aprove($test2[$i])===false)
			$aux2=false;

	session_start();
	$sir=checkmoderator($_SESSION['user']);
	if (getUserRole($_SESSION['user'])!=1 && $sir[0]!=1) 
		echo 'Nu aveti drepturi';
	else if (empty($continut) || count($test)<50)
		echo 'Articolul trebuie sa contina cel putin 50 de cuvinte';
	else if (!$aux)
		echo 'Articolul contine cuvinte interzise';
	else if (!$aux2)
		echo 'Titlul articolului contine cuvinte interzise';
	else if (empty($titlu))
	    echo 'Lipseste titlul';
	else if ($x=newArticle($titlu,$continut))
		    echo 'Articol publicat <a href="articol.php?id='.htmlspecialchars($x).'">aici</a>';
	else
	    echo 'Ceva nu a mers cum trebuie';
?>
