<!DOCTYPE html>

<head>
    <title>Resetare cont</title>
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
	
	session_start();
	$username=$_SESSION['user'];
	
	if (!remDetails($username))
		echo 'Ceva nu a decurs cum trebuie <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	else
		echo 'Datele au fost resetate <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
?>
    </div>
</div>

</body>

</html>
