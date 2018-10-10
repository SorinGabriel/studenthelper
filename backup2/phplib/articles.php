<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	date_default_timezone_set("Europe/Bucharest");
	
	include_once 'connectdb.php';

    function ArticleExist($art)
    {
        if (empty($art))
            return false;

        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM articole WHERE articol_id=?");
        $sql->bind_param("i",$art);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            return false;
        }
        $sql->bind_result($nr);
        $sql->fetch();
        $sql->close();

        $conn->close();

        if ($nr==0)
            return false;
        return true;
    }

	function newArticle($title,$content)
	{
        if (empty($title))
            die ("Lipseste titlul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($content))
            die ("Lipseste continutul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

		$conn=connect();
		
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			session_start();
		}			
		$author=$_SESSION['user'];
		$data=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
		$sql=$conn->prepare("INSERT INTO `articole` (titlu,continut,autor,data) VALUES(?,?,?,?)"); //error 2
		$sql->bind_param("ssss",$title,$content,$author,$data);
		if (!$sql->execute())
		{
			$sql->close();
			$conn->close();
            die('Eroare la publicarea articolului(error2) articles.php newArticle 1'.$sql->error. ' <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button> ');
			return false;
		}
		$id=$sql->insert_id;
		$sql->close();
		$conn->close();
		return $id;
	}
	
	function updateArticle($id,$title,$content)
	{
        if (empty($id))
            die ("Lipseste articolul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($content))
            die ("Lipseste continutul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($title))
            die ("Lipseste titlul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!ArticleExist($id))
            die ("Articolul nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

		$conn=connect();
		
		if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		{
			session_start();
		}			
		//$author=$_SESSION['user'];
		//$data=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
		$sql=$conn->prepare("UPDATE `articole` SET titlu=?, continut=? WHERE articol_id=?"); //error 2
		$sql->bind_param("ssi",$title,$content,$id);
		if (!$sql->execute())
		{

			$sql->close();
			$conn->close();
            die('Eroare la publicarea articolului(error2) articles.php updateArticle 1 '.$sql->error.' <button class="btn btn-default" onclick="history.go(-1);">Inapoi </button> ');
			return false;
		}
		$sql->close();
		$conn->close();
		return true;
	}

	function deleteArticle($id,$uname)
	{
        if (empty($id))
            die ("Lipseste articolul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($uname))
            die ("Lipseste unameul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!ArticleExist($id))
            die ("Articolul nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

		include_once 'usersactions.php';
		$conn=connect();
		
		$sir=checkmoderator($uname);
		if (getUserRole($uname)!=1 && $sir[0]!=1) {
            die("Nu aveti drepturile de a sterge <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql=$conn->prepare("DELETE FROM articole WHERE articol_id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error articles.php deleteArticle 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM comentarticole WHERE articol=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error articles.php deleteArticle 2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM ratingarticole WHERE articol_id=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error articles.php deleteArticle 3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->close();
		$conn->close();
		return true;
	}
	
	function postComment($user,$comment,$articol)
	{
		$conn=connect();
		
		$data=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
		$sql=$conn->prepare("INSERT INTO `comentarticole` (utilizator,articol,mesaj,data) VALUES(?,?,?,?)");
		$sql->bind_param("iiss",$user,$articol,$comment,$data);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->close();
		$conn->close();
		return true;
	}
	
	function deleteComment($id)
	{
		$conn=connect();
		
		$sql=$conn->prepare("DELETE FROM comentarticole WHERE id=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error articles.php deleteCom 1");
            return false;
        }
        
        $sql->close();
        $conn->close();
        return true;
	}
	
	function getCommentAuthor($id)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT utilizator FROM comentarticole WHERE id=?");
		$sql->bind_param("i",$id);
		if (!$sql->execute())
		{
			$sql->close();
			$conn->close();
			die("Query error getcommentauthor");
			return -1;
		}
		$sql->bind_result($uid);
		$sql->fetch();
		
		$sql->close();
		$conn->close();
		
		return $uid;
	}
	
	function getComments($aid)
	{
		include_once 'usersactions.php';
		$conn=connect();
		
		$sql=$conn->prepare("SELECT ca.id,ca.mesaj,u.username,ca.data FROM `comentarticole` ca, `utilizatori` u WHERE articol=? and u.user_id=ca.utilizator ORDER BY data");
		$sql->bind_param("i",$aid);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id,$mesaj,$utilizator,$data);
		$i=1;
		while ($sql->fetch())
		{
			if ($i==1) echo '    <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 well"><h3>Comentarii:</h3>';
			$i++;
			echo '<div class="media"> 
                    <div class="media-left">
                        <img src="';getUserPhoto($utilizator);
            echo '" class="media-object" style="width:60px">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="user.php?username='.htmlspecialchars($utilizator).'">'.htmlspecialchars($utilizator).'</a>';
			if (isset($_SESSION['user']) && !empty($_SESSION['user']))
			{
				$user=$_SESSION['user'];
				$sir=checkmoderator($user);
				if (!(getUserRole($user)!=1 && $sir[0]!=1 && strcmp($user,$utilizator)!=0))
					echo '<button class="btn btn-link" onclick="deletecom('.$id.')">Sterge comentariul</button>';                                         
            }
            echo '                        </h4>
                        <p>'.htmlspecialchars($mesaj).'</p>  </div></div><hr>';
		}
		if ($i>1)
		    echo '</div></div>';
		
		$sql->close();
		$conn->close();
	}
	
?>
