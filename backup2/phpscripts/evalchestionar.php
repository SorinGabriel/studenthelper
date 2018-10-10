<?php

	include_once '../phplib/chestionare.php';

	$id=$_POST['id'];
	$answers=getAnswers($id);
	
	echo json_encode($answers);
?>