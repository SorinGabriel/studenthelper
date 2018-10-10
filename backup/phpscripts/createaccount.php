<?php

	include_once '../phplib/usersactions.php';
	
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$mail=$_POST['mail'];
	
	if (!preg_match('/^(?=.{8,20}$)(?![_.])[a-zA-Z0-9._]+(?<![_.])$/', $user))
		die("Username-ul trebuie sa:<ul><li>Nu contina diacritice</li><li>Contina intre 8 si 20 de caractere</li><li>Nu inceapa cu underscore sau punct</li><li>Sa contina doar litere, cifre, punct sau underscore</li><li>Sa nu aiba underscore sau punct la final</li></ul>");
	
	if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $pass) === 0)
		die("Parola trebuie sa contina cel putin 8 caractere, o litera mica, una mare si o cifra");

	if (filter_var($mail, FILTER_VALIDATE_EMAIL))
	{
		if (mailValidation($mail))
			if (userValidation($user))
				if (newuser($user,$pass,$mail))
					if (authentification($user,$pass))
					{
						newsession($user,$pass);
						die("Te-ai inregistrat cu succes");
					}
					else
						die("User sau parola gresita");
				else
					die ("User sau parola gresita");
			else
				die ("Username-ul este deja folosit de cineva");
		else
			die ("Adresa de mail este folosita de cineva");
	}
	else
		die ("Adresa de mail invalida");

?>
