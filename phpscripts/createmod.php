<!DOCTYPE html>

<head>
    <title>Adaugare moderator</title>
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

	include_once '../phplib/admin.php';
	include_once '../phplib/usersactions.php';
	
	$nume=$_POST['username'];
	$articole=-1;
	$qa=-1;
	$chestionare=-1;
	if (isset($_POST['articole']) && $_POST['articole']==1)
		$articole=1;
	if (isset($_POST['qa']) && $_POST['qa']==1)
		$qa=1;
	if (isset($_POST['chestionare']) && $_POST['chestionare']==1)
		$chestionare=1;

	session_start();
	if (getUserRole($_SESSION['user'])!=1)
		echo 'Nu aveti drepturi';
	else if ($articole==$qa && $qa==$chestionare && $chestionare==-1)
	    echo 'Nu ati selectat tipul de moderator <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
    else if (createmod($nume,$articole,$qa,$chestionare))
		echo 'Moderatorul a fost creat <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
	
?>
    </div>
</div>

</body>

</html>
