<?php
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/7/2017
 * Time: 6:48 PM
 */

    function mailsender($to,$subject,$mesage,$user)
    {
        $from="studenthelperlicenta@gmail.com";
        require("../PHPMailer_5.2.0/class.phpmailer.php");

        $mail = new PHPMailer();

        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->SMTPDebug = false;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;// specify main and backup server
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = $from;  // SMTP username
        $mail->Password = "a+Kb+-gT5Pf-3L3W"; // SMTP password
        $mail->From = $from;
        $mail->FromName = "StudentHelper";
        $mail->AddAddress($to, $user);

        $mail->IsHTML(true);

        $mail->Subject = $subject;
        $mail->Body    = $mesage;
        $mail->AltBody = html_entity_decode($mesage);

        if(!$mail->Send())
        {
            return false;
        }

        return true;
	}
