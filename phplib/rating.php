<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	date_default_timezone_set("Europe/Bucharest");
	
	include_once 'connectdb.php';
	
	function checkRatingArt($articol,$user)
	{
		include_once 'usersactions.php';
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nota FROM ratingarticole WHERE user_id=? and articol_id=?");
		$user=getUserId($user);
		$sql->bind_param("ii",$user,$articol);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		if ($sql->num_rows<1)
		{
			$sql->close();
			$conn->close();
			return false;
		}
		$sql->bind_result($nota);
		$sql->fetch();
		
		$sql->close();
		$conn->close();
		return $nota;
	}
	
	function rateArt($articol,$user,$nota)
	{
		if ($nota<1 || $nota>10 || is_float($nota))
			return false;
		include_once 'usersactions.php';
		$conn=connect();
		
		if (!checkRatingArt($articol,$user))
		{
			$sql=$conn->prepare("INSERT INTO ratingarticole (articol_id,user_id,nota) VALUES(?,?,?)");
			$user=getUserId($user);
			$sql->bind_param("iii",$articol,$user,$nota);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
			$sql->close();
			$conn->close();
			return $nota;
		}
		else
		{
			$sql=$conn->prepare("UPDATE ratingarticole SET nota=? WHERE articol_id=? and user_id=?");
			$user=getUserId($user);
			$sql->bind_param("iii",$nota,$articol,$user);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
			$sql->close();
			$conn->close();
			return $nota;
		}
	}
	
	function getRateArt($articol)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nota FROM ratingarticole WHERE articol_id=?");
		$sql->bind_param("i",$articol);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nota);
		$nr=0;
		$total=0;
		while ($sql->fetch())
		{
			$total+=$nota;
			$nr++;
		}

		if ($nr==0) $final=0;
			else $final=$total/$nr;
		$final=number_format($final, 2, '.', '');
		$sql->close();
		$conn->close();		
		return array($final,$nr);
	}
	
	function checkRatingQA($qa,$user)
	{
		include_once 'usersactions.php';
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nota FROM ratingqa WHERE user_id=? and qa_id=?");
		$user=getUserId($user);
		$sql->bind_param("ii",$user,$qa);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		if ($sql->num_rows<1)
		{
			$sql->close();
			$conn->close();
			return false;
		}
		$sql->bind_result($nota);
		$sql->fetch();
		
		$sql->close();
		$conn->close();
		return $nota;
	}
	
	function rateQA($qa,$user,$nota)
	{
		if ($nota<1 || $nota>10 || is_float($nota))
			return false;
		include_once 'usersactions.php';
		$conn=connect();

		if (!checkRatingQA($qa,$user))
		{
			$sql=$conn->prepare("INSERT INTO ratingqa (qa_id,user_id,nota) VALUES(?,?,?)");
			$user=getUserId($user);
			$sql->bind_param("iii",$qa,$user,$nota);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
			$sql->close();
			$conn->close();
			return $nota;
		}
		else
		{
			$sql=$conn->prepare("UPDATE ratingqa SET nota=? WHERE qa_id=? and user_id=?");
			$user=getUserId($user);
			$sql->bind_param("iii",$nota,$qa,$user);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
			$sql->close();
			$conn->close();
			return $nota;
		}
	}
	
	function getRateQa($qa)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nota FROM ratingqa WHERE qa_id=? and user_id <> (SELECT user FROM qapost WHERE id=?)");
		$sql->bind_param("ii",$qa,$qa);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nota);
		$nr=0;
		$total=0;
		while ($sql->fetch())
		{
			$total+=$nota;
			$nr++;
		}
		
		if ($nr==0) $final=0;
			else $final=$total/$nr;
		$final=number_format($final, 2, '.', '');
		$sql->close();
		$conn->close();		
		return array($final,$nr);
	}
	
	function checkRatingChestionare($chestionar,$user)
	{
		include_once 'usersactions.php';
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nota FROM ratingchestionare WHERE user_id=? and chestionar_id=?");
		$user=getUserId($user);
		$sql->bind_param("ii",$user,$chestionar);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		if ($sql->num_rows<1)
		{
			$sql->close();
			$conn->close();
			return false;
		}
		$sql->bind_result($nota);
		$sql->fetch();
		
		$sql->close();
		$conn->close();
		return $nota;
	}
	
	function rateChestionare($chestionar,$user,$nota)
	{
		if ($nota<1 || $nota>10 || is_float($nota))
			return false;
		include_once 'usersactions.php';
		$conn=connect();
		
		if (!checkRatingChestionare($chestionar,$user))
		{
			$sql=$conn->prepare("INSERT INTO ratingchestionare (chestionar_id,user_id,nota) VALUES(?,?,?)");
			$user=getUserId($user);
			$sql->bind_param("iii",$chestionar,$user,$nota);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
			$sql->close();
			$conn->close();
			return $nota;
		}
		else
		{
			$sql=$conn->prepare("UPDATE ratingchestionare SET nota=? WHERE chestionar_id=? and user_id=?");
			$user=getUserId($user);
			$sql->bind_param("iii",$nota,$chestionar,$user);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
			$sql->close();
			$conn->close();
			return $nota;
		}
	}
	
	function getRateChestionare($chestionar)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nota FROM ratingchestionare WHERE chestionar_id=? and user_id <> (SELECT user_id FROM chestionare WHERE id=?)");
		$sql->bind_param("ii",$chestionar,$chestionar);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nota);
		$nr=0;
		$total=0;
		while ($sql->fetch())
		{
			$total+=$nota;
			$nr++;
		}
		
		if ($nr==0) $final=0;
			else $final=$total/$nr;
		$final=number_format($final, 2, '.', '');
		$sql->close();
		$conn->close();		
		return array($final,$nr);
	}	
	
	
?>
