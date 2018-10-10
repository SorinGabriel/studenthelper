<!DOCTYPE html>

<head>
    <title>Adaugare specializare</title>
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

$nume=$_POST['specializare'];
$fac=$_POST['facultate'];

session_start();
if (getUserRole($_SESSION['user'])!=1)
	echo 'Nu aveti drepturi';
else if (insertSpec($nume,$fac))
    echo 'S-a adaugat cu succes <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
else
    echo 'Ceva nu a mers bine <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';

?>
    </div></div>
</body>

</html>
