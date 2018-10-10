<!DOCTYPE html>

<head>
    <title>Stergere categorie QA</title>
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
	
	$id=$_POST['categorie'];
	
	session_start();
	if (getUserRole($_SESSION['user'])!=1)
		echo 'Nu aveti drepturi';
	else if (deleteQAcat($id))
		echo 'Categoria a fost stearsa <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	
?>
    </div>
</div>
</body>

</html>

