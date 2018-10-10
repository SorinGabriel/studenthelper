<?php
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/7/2017
 * Time: 6:29 PM
 */

    include_once '../phplib/usersactions.php';

    $mail=$_POST['mailnou'];
    $confirm=$_POST['confirm'];
    $oldmail=$_POST['mailvechi'];
    session_start();

    if (filter_var($mail, FILTER_VALIDATE_EMAIL))
    {
        if (mailValidation($mail))
        {
            if (strcmp($mail,$confirm)!=0)
                echo 'Adresele de mail nu coincid';
            else if (changeMailRequest(getUserId($_SESSION['user']),$mail,$oldmail))
                echo 'S-a trimis un mail pentru verificare catre adresa:'.$oldmail;
            else
                echo 'Ai mai facut o solicitare in ultimele 24 de ore';
        }
        else
            echo 'Adresa de mail este folosita de altcineva';
    }
    else
        die ("Adresa de mail invalida");


    ?>
