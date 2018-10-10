<!DOCTYPE html>

<head>
    <title>Adaugare categorie qa</title>
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
	include_once '../phplib/qa.php';
	
	$nume=$_POST['ncat'];
	$url=$_POST['url'];

	session_start();
	if (getUserRole($_SESSION['user'])!=1)
		echo 'Nu aveti drepturi';
	else if (preg_match("/\\s/", $url))
		echo 'Url-ul nu poate sa contina spatii albe. <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';	
	else if (createCategory($nume,$url))
		echo 'Categoria a fost adaugata <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	else 
		echo 'Ceva nu a mers bine <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	
?>
    </div>
</div>
</body>

</html>
