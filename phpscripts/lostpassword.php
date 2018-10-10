<?php
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/8/2017
 * Time: 1:20 AM
 */

    include_once '../phplib/usersactions.php';
    include_once '../phplib/lostpassword.php';

    $mail=$_POST['mail'];

    if (getUserIdByMail($mail)==-1)
        echo 'Utilizatorul nu a fost gasit';
    else if (changePassRequest($mail))
        echo 'S-a trimis un mail pentru catre adresa:'.htmlspecialchars($mail);
    else
        echo 'Ai mai facut o solicitare in ultimele 24 de ore';