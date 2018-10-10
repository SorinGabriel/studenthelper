
<!DOCTYPE html>

<head>
	<title>Adaugare grupa</title>
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

	include_once '../phplib/chestionare.php';
	include_once '../phplib/censorship.php';

	$titlu=$_POST['titlu'];
	$descriere=$_POST['descriere'];
	$timp=$_POST['timp'];
	$categorie=$_POST['categorie'];
	$nrintrebari=$_POST['numarintrebari'];
	$i=1;
	$data=array();
    session_start();
    $user=$_SESSION['user'];

    while ($nrintrebari>0) {
        if (isset($_POST['intrebare'.$i]) && !empty($_POST['intrebare'.$i]))
        {
            array_push($data, $_POST['intrebare'.$i], $_POST['rasp1i'.$i], $_POST['rasp2i'.$i],$_POST['rasp3i'.$i],$_POST['rasp4i'.$i],$_POST['raspunsi'.$i]);
            $nrintrebari--;
        }
        $i++;
    }

	$cenzura=new censorship();
	$test=explode(" ",$descriere);
	$aux2=true;
	$test2=explode(" ",$titlu);
	$aux=true;
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
	else if (!is_numeric($timp) || $timp<60)
		echo 'Timpul trebuie sa fie un numar mai mare de 60 <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	else if (insertChestionar($titlu,$descriere,$timp,$data,$categorie,$user))
	    header ('Location: /');
	else
		echo 'Ceva nu a mers bine <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
?>
	</div>
</div>
</body>

</html>