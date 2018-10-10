<!DOCTYPE html>

<head>
    <title>QA - Postare noua</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="../styles/bs/css/bootstrap.min.css">
    <script src="../styles/jquery.min.js"></script>
    <script src="../styles/bs/js/bootstrap.min.js"></script>
    <!-- end bootstrap -->
</head>
<body>
<div class="container-fluid">
    <div class="well">
<?php

	include_once '../phplib/qa.php';
	include_once '../phplib/usersactions.php';
	include_once '../phplib/censorship.php';
	
	$subiect=$_POST['subiect'];
	$mesaj=$_POST['mesaj'];
	$categorie=$_POST['categorie'];
	session_start();
	$user=$_SESSION['user'];
	$user=getUserId($user);
	$test=explode(" ",$mesaj);
	$x=false;
	if (count($test)<=3)
		echo 'Intrebarea trebuie sa contina minim 4 cuvinte <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	else
	{
		$x=newQA($subiect,$mesaj,$user,$categorie);
		$cenzura=new censorship();
		$aux=true;
		$aux2=true;
		$test2=explode(" ",$subiect);
		for ($i=0;$i<count($test);$i++)
			if ($cenzura->aprove($test[$i])===false)
				$aux=false;
		for ($i=0;$i<count($test2);$i++)
			if ($cenzura->aprove($test2[$i])===false)
				$aux2=false;
		if ($aux2===false)
			echo 'Subiectul contine cuvinte interzise <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		else if ($aux===false)
			echo 'Mesajul contine cuvinte interzise <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		else if (empty($subiect))
			echo 'Lipseste subiectul  <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		else if (empty($mesaj))
			echo 'Lipseste mesajul  <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		else if (!$x)
			echo 'Ceva nu a mers bine  <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		else
			header('location: /raspunsuri.php?grup='.$x);
	}
?>
    </div>
</div>

</body>

</html>
