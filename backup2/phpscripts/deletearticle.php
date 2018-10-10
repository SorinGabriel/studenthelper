<?php

	include_once '../phplib/articles.php';
	
	$id=$_POST['aid'];
	$uname=$_POST['uname'];
	
	if (deleteArticle($id,$uname))
		echo 'Succes';
	else 
		echo 'Ceva nu a mers bine';
	
?>