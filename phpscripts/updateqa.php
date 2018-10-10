<?php

	include '../phplib/qa.php';
	include_once '../phplib/censorship.php';

	$id=$_POST['id'];
	$titlu=$_POST['titlu'];
	$continut=$_POST['content'];

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

	if (count($test)<4)
		echo 'Continutul trebuie sa aiba cel putin 4 cuvinte';
	else if (!$aux)
		echo 'Mesajul contine cuvinte interzise';
	else if (!$aux2)
		echo 'Titlul contine cuvinte interzise';
    else if (empty($titlu))
        echo 'Lipseste subiectul';
    else if (empty($continut))
        echo 'Lipseste mesajul';
	else if (updateQA($id,$titlu,$continut))
		echo 'Succes';
	
?>
