<!DOCTYPE html>

<head>
    <title>Modificare detalii</title>
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

	include_once '../phplib/usersactions.php';
	include_once '../phplib/censorship.php';
	include_once '../phplib/nf.php';
	
	$filter=new ImageFilter;
	
	session_start();
	$username=$_SESSION['user'];
	$poza=$_FILES["poza"]["name"];

    if (isset($_POST['grupa']) && !empty($_POST['grupa']))
        $grupa=$_POST['grupa'];
    else
        $grupa='';
    $detalii=$_POST['detalii'];
    $cenzura=new censorship();
    $test=explode(" ",$detalii);
	
	$aux=true;
	if (strlen($detalii)>0)
	{
		for ($i=0;$i<count($test);$i++)
			if ($cenzura->aprove($test[$i])===false)
				$aux=false;
	}
			
    $github=$_POST['github'];
    if (isset($_POST['publicmail']) && strcmp($_POST['publicmail'],'Yes')==0)
        $publicmail=1;
    else
        $publicmail=-1;

	$target_dir = "../uploads/";
	$target_file = $target_dir . md5(uniqid(rand(), true)) . basename($_FILES["poza"]["name"]);
    $poza=$target_file;
	if (!$aux)
		echo 'Detaliile contin cuvinte interzise <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	else
	{
		if (empty($_FILES['poza']['name']) || !isset($_FILES['poza']['name']))
		{
			if (!updateDetails($username,'',$grupa,$detalii,$github,$publicmail))
				echo 'Ceva nu a decurs cum trebuie <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
			else
				echo 'Detaliile contului au fost modificate <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		}
		else
		{
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			$check = getimagesize($_FILES["poza"]["tmp_name"]);
			$score=$filter->GetScore($_FILES["poza"]["tmp_name"]);
			if ($score>=60)
				die("Imaginea e posibil sa aiba continut nud <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
			if ($check == false)
				die("Fisierul nu este o imagine <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
			if (file_exists($target_file))
				die("Fisierul exista deja.Incercati din nou <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
			if ($_FILES["poza"]["size"] > 5000000)
				die("Fisierul este prea mare <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
				die("Formatul fisierul nu este acceptat <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

			if (!empty($_FILES['poza']['name']) && isset($_FILES['poza']['name'])) {
				move_uploaded_file($_FILES['poza']['tmp_name'], $target_file);
				$poza = $target_file;
			}
			if (!updateDetails($username,$poza,$grupa,$detalii,$github,$publicmail))
				echo 'Ceva nu a decurs cum trebuie <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
			else
				echo 'Detaliile contului au fost modificate <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		}
	}

?>
    </div>
</div>

</body>

</html>
