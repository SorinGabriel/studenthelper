<?php


	function connect()
	{
		/* functie de conectare la baza de date */
		//$conn = new mysqli('localhost','root','parolabd','studenthelper'); //eroare 0
		$conn = new mysqli('localhost','root','','studenthelper'); //eroare 0
		if (mysqli_connect_errno()) {
		  exit('Eroare conexiune(eroare 0)');
		}
		mysqli_set_charset($conn, 'utf8');
		return $conn;
	}

?>
