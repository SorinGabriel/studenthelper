<!DOCTYPE html>

<head>
    <title>Sterge categorie chestionar</title>
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
include_once '../phplib/usersactions.php';

$id=$_POST['categorie'];
session_start();
$user=$_SESSION['user'];

if (getUserRole($user)!=1)
	echo 'Nu aveti drepturi';
else if (deleteChestCat($id,$user))
    echo 'Categoria a fost stearsa <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';

?>
    </div>
</div>

</body>

</html>

