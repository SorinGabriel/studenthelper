
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
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/6/2017
 * Time: 5:50 PM
 */
include_once '../phplib/facilities.php';
include_once '../phplib/usersactions.php';

$grupa=$_POST['grupa'];
$serie=$_POST['serie'];
$an=$_POST['an'];
$spec=$_POST['specializare'];

session_start();
if (getUserRole($_SESSION['user'])==1)
{
	$poza=$_FILES["poza"]["name"];

	$target_dir = "../orar/";
	$target_file = $target_dir . md5(uniqid(rand(), true)) . basename($_FILES["poza"]["name"]);

	if (empty($_FILES['poza']['name']) || !isset($_FILES['poza']['name']))
	{
		$poza="../images/emptyorar.png";
		if (!insertGroup($grupa,$serie,$an,$spec,$poza))
			echo 'Ceva nu a decurs cum trebuie <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		else
			echo 'Grupa a fost adaugata <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	}
	else
	{
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		$check = getimagesize($_FILES["poza"]["tmp_name"]);
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
		if (!insertGroup($grupa,$serie,$an,$spec,$poza))
			echo 'Ceva nu a decurs cum trebuie <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
		else
			echo 'Grupa a fost adaugata <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';

	}
}
else
	echo 'Nu aveti drepturi';
?>
    </div>
</div>
</body>

</html>
