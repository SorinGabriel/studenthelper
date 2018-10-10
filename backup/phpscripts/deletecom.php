<?php

	include_once '../phplib/articles.php';
	include_once '../phplib/usersactions.php';

	$id=$_POST['id'];
	session_start();
	$user=$_SESSION['user'];

	$author=getCommentAuthor($id);

	$sir=checkmoderator($user);
	if (getUserRole($user)!=1 && $sir[0]!=1 && strcmp($user,getUsername($author))!=0)
            	echo 'Nu aveti drepturile de a sterge comentariul';
	else if (deleteComment($id))
		echo 'Succes';
	else
		echo 'Fail';

?>
