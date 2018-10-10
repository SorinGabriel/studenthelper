<!DOCTYPE html>

<head>
    <title>Stergere specializare</title>
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
 * Date: 4/7/2017
 * Time: 12:41 AM
 */
include_once '../phplib/facilities.php';
include_once '../phplib/usersactions.php';

$spec=$_POST['specializare'];

session_start();
if (getUserRole($_SESSION['user'])!=1)
	echo 'Nu aveti drepturi';
else if (deleteSpec($spec))
    echo 'Specializarea a fost stearsa <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
else
    echo 'S-a produs o eroare <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';

?>
    </div>
</div>
</body>
</html>
