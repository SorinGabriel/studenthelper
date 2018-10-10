<?php
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/8/2017
 * Time: 2:01 AM
 */

    include_once '../phplib/usersactions.php';

    $opass=$_POST['parolaveche'];
    $npass=$_POST['parolanoua'];
    $conf=$_POST['confirmare'];
    session_start();
    $user=$_SESSION['user'];

    if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $npass) === 0)
		echo "Parola trebuie sa contina cel putin 8 caractere, o litera mica, una mare si o cifra";
    else if (strcmp($npass,$conf)!=0)
        echo 'Parolele nu coincid';
    else if (changePass($user,$opass,$npass))
        echo 'Parola a fost modificata';
    else
        echo 'Parola veche este gresita';
