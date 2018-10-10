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
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/8/2017
 * Time: 1:47 AM
 */

    include_once '../phplib/lostpassword.php';

    $npass=$_POST['newpass'];
    $key=$_POST['key'];
    $user=$_POST['user'];

	if(!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $npass) === 0)
		echo 'Parola trebuie sa contina cel putin 8 caractere, o litera mica, una mare si o cifra <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
    else if (changePass2($key,$user,$npass))
        echo 'Parola a fost modificata <button class="btn btn-default" onclick="window.location.replace(\'/\');">Inapoi </button>';
    else
        echo 'Ceva nu a functionat <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button>';
?>
    </div>
</div>
</body>

</html>
