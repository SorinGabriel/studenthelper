<!DOCTYPE html>

<head>
    <title>Adaugare facultate</title>
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

$nume=$_POST['facultate'];

session_start();
if (getUserRole($_SESSION['user'])!=1)
	echo 'Nu aveti drepturi';
else if (insertFacultate($nume))
    echo 'Facultatea a fost adaugata <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
else
    echo 'Facultatea exista deja <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';

?>
    </div></div>
</body>

</html>
