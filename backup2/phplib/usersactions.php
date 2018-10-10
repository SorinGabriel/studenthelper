<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
	include_once 'connectdb.php';

    date_default_timezone_set("Europe/Bucharest");

	function newuser($user,$pass,$mail)
	{
		$conn=connect();
		
		$pass=md5($pass);		
		$sql=$conn->prepare("INSERT INTO `utilizatori` (username,password,mail)
		VALUES (?,?,?)");           // eroare 1
		$sql->bind_param("sss",$user,$pass,$mail);
		if (!$sql->execute())
		{
			$sql->close();
			$conn->close();
			die("Eroare utilizator nou(Eroare 1)");
			return false;
		}
		
		$sql->close();
		$conn->close();
		return true;
	}

	function authentification($user,$pass)
	{
		$conn=connect();
		
		$pass=md5($pass);
		$sql=$conn->prepare("SELECT count(*) FROM `utilizatori` WHERE username=? and password=?");
		$sql->bind_param("ss",$user,$pass);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($numar);
		$sql->fetch();
		
		$sql->close();
		$conn->close();
		
		if ($numar != 1)
			return false;
		return true;
	}
	
	function userValidation($user)
	{
		$conn=connect();
		$sql=$conn->prepare("SELECT count(*) FROM `utilizatori` WHERE username=?");
		$sql->bind_param("s",$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($numar);
		$sql->fetch();
		$sql->close();
		$conn->close();
		if ($numar>0)
			return false;
		return true;
	}
	
	function mailValidation($mail)
	{
		$conn=connect();
		$sql=$conn->prepare("SELECT count(*) FROM `utilizatori` WHERE mail=?");
		$sql->bind_param("s",$mail);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($numar);
		$sql->fetch();
		$sql->close();
		$conn->close();
		if ($numar>0)
			return false;
		return true;		
	}
	
	function newsession($user,$pass)
	{
		session_start();
		$_SESSION['user']=$user;
		$_SESSION['pass']=$pass;
	}
	
	function killsession()
	{
		session_start();
		session_unset(); 
		session_destroy(); 
		return true;
	}
	
	function checkifauth()
	{
		if(session_id() == '' || !isset($_SESSION)) {
			session_start();
		}
		if (!isset($_SESSION['user']) || empty($_SESSION['user']) || !isset($_SESSION['pass']) || empty($_SESSION['pass']))
			return false;
		return authentification($_SESSION['user'],$_SESSION['pass']);
	}
	
	function getUserRole($user)
	{
		//1=administrator,0=user obisnuit
		$conn=connect();
		$sql=$conn->prepare("SELECT user_id FROM `utilizatori` WHERE username=?");
		$sql->bind_param("s",$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($uid);
		$sql->fetch();
		$sql->free_result();
		$sql=$conn->prepare("SELECT count(*) FROM `administratori` WHERE user_id=?");
		$sql->bind_param("i",$uid);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nr);
		$sql->fetch();
		$sql->close();
		$conn->close();		
		if ($nr>0)
			return 1;
		return 0;
	}
	
	function checkModerator($user)
	{
		$uid=getUserId($user);
		$conn=connect();
		$sql=$conn->prepare("SELECT articole,qa,chestionare FROM moderatori WHERE user_id=?");
		$sql->bind_param("s",$uid);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		if ($sql->num_rows()<1) 
		{
			$sql->close();
			$conn->close();
			return array(-1,-1,-1);
		}
		$sql->bind_result($articole,$qa,$chestionare);
		$sql->fetch();
		$sql->close();
		$conn->close();
		return array($articole,$qa,$chestionare);
	}
	
	function getUserId($user)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT user_id FROM `utilizatori` WHERE username=?");
		$sql->bind_param("s",$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return -1;
        }
		$sql->bind_result($uid);
		$sql->fetch();
		$sql->close();

		$conn->close();
		if (empty($uid) || !isset($uid))
		    $uid=-1;
		return $uid;
	}
	
	function getUsername($uid)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT username FROM `utilizatori` WHERE user_id=?");
		$sql->bind_param("i",$uid);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return -1;
        }
		$sql->bind_result($username);
		$sql->fetch();
		$sql->close();

		$conn->close();
        if (empty($username) || !isset($username))
            $username=-1;
		return $username;		
	}
	
	function getUserPhoto($username)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT poza FROM `utilizatori` WHERE username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($photo);
		$sql->fetch();
		$sql->close();		
		
		$conn->close();
		
		echo $photo;
	}
	
	function getSpecializare($username)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT s.nume FROM utilizatori u,grupa g,specializare s WHERE u.grupa=g.id and g.specializare=s.id and u.username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($specializare);
		$sql->fetch();
		$sql->close();		
		
		$conn->close();

		if (empty($specializare))
		    $specializare="Necunoscuta";
		return $specializare;
	}

    function getSpecializareId($username)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT s.id FROM utilizatori u,grupa g,specializare s WHERE u.grupa=g.id and g.specializare=s.id and u.username=?");
        $sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($specializare);
        $sql->fetch();
        $sql->close();

        $conn->close();

        if (empty($specializare))
            $specializare=-1;
        return $specializare;
    }

	function getGrupa($username)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT g.nume FROM grupa g,utilizatori u WHERE g.id=u.grupa and username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($grupa);
		$sql->fetch();
		$sql->close();		
		
		$conn->close();

		if (empty($grupa) || $grupa==-1)
		    $grupa="Necunoscuta";
		return $grupa;		
	}

    function getGrupaId($username)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT g.id FROM grupa g,utilizatori u WHERE g.id=u.grupa and username=?");
        $sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($grupa);
        $sql->fetch();
        $sql->close();

        $conn->close();

        if (empty($grupa) || $grupa==-1)
            $grupa=-1;

        return $grupa;
    }
	
	function getDetalii($username)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT detalii FROM `utilizatori` WHERE username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($detalii);
		$sql->fetch();
		$sql->close();		
		
		$conn->close();
		
		if (!empty($detalii))
			return $detalii;
		else
		    return "N/A";
	}
	
	function getSerie($username)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT g.serie FROM utilizatori u,grupa g WHERE u.grupa=g.id and u.username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($serie);
		$sql->fetch();
		$sql->close();		
		
		$conn->close();

		if (empty($serie))
		    $serie="Necunoscuta";
		return $serie;
	}

	function getFac($username)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT f.nume FROM utilizatori u,grupa g,facultate f,specializare s WHERE u.grupa=g.id and g.specializare=s.id and f.id=s.id_facultate and u.username=?");
        $sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($facultate);
        $sql->fetch();
        $sql->close();

        $conn->close();

        if (empty($facultate))
            $facultate="Necunoscuta";
        return $facultate;
    }

    function getFacId($username)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT f.id FROM utilizatori u,grupa g,facultate f,specializare s WHERE u.grupa=g.id and g.specializare=s.id and f.id=s.id_facultate and u.username=?");
        $sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($facultate);
        $sql->fetch();
        $sql->close();

        $conn->close();

        if (empty($facultate))
            $facultate=-1;
        return $facultate;
    }


    function getAn($username)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT g.an FROM grupa g,utilizatori u WHERE u.grupa=g.id and u.username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($an);
		$sql->fetch();
		$sql->close();		
		
		$conn->close();
		if (empty($an))
			return "Necunoscut";
		else 
			return $an;
	}
	
	function getPublic($username)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT publicmail FROM `utilizatori` WHERE username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($public);
		$sql->fetch();
		$sql->close();		
		
		$conn->close();
		
		return $public;		
	}

	function getGit($username)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT github FROM `utilizatori` WHERE username=?");
        $sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($git);
        $sql->fetch();
        $sql->close();

        $conn->close();

        if (empty($git))
            return "N/A";
        else
            return $git;
    }
	
	function getMail($username,$public=-1)
	{
		if ($public==-1 && getPublic($username)==-1)
			return "Nu este public";
		else 
		{
			$conn=connect();
			
			$sql=$conn->prepare("SELECT mail FROM `utilizatori` WHERE username=?");
			$sql->bind_param("s",$username);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
			$sql->bind_result($mail);
			$sql->fetch();
			$sql->close();		
			
			$conn->close();
			
			return $mail;
		}
	}
	
	function getUserIdByMail($mail)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT user_id FROM `utilizatori` WHERE mail=?");
        $sql->bind_param("s",$mail);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return -1;
        }
        $sql->bind_result($uid);
        $sql->fetch();
        $sql->close();

        $conn->close();
        if (empty($uid) || !isset($uid))
            $uid=-1;
        return $uid;
    }

	function updateDetails($username,$poza,$grupa,$detalii,$github,$publicmail)
	{
		error_reporting(E_ALL);
		$conn=connect();

        $sql=$conn->prepare("SELECT poza FROM utilizatori WHERE username=?");
        $sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($poza2);
        $sql->fetch();
        $sql->free_result();

        if (strcmp($poza2,'../uploads/user.png')!=0 && strcmp($poza2,'uploads/user.png')!=0 && (!empty($poza) && isset($poza) && $poza!='../uploads/'))
            unlink($poza2);

		if (empty($poza) || !isset($poza) || $poza=='../uploads/')
			$poza=$poza2;//$poza='../uploads/user.png';
		if (empty($grupa))
		    $grupa=-1;
		$sql=$conn->prepare("UPDATE utilizatori SET poza=?,grupa=?,detalii=?,github=?,publicmail=? WHERE username=?");
		$sql->bind_param("ssssis",$poza,$grupa,$detalii,$github,$publicmail,$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		
		$sql->close();
		$conn->close();
		return true;
	}
	
	
	function remDetails($username)
	{
		error_reporting(E_ALL);
		$conn=connect();
		
		$sql=$conn->prepare("SELECT count(*),poza FROM utilizatori WHERE poza=(SELECT poza FROM utilizatori WHERE username=?) and poza <> 'uploads/user.png' GROUP BY poza");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nr,$poza2);
		$sql->fetch();
		$sql->free_result();
		
		if ($nr==1 && strcmp($poza2,'../uploads/user.png')!=0 && strcmp($poza2,'uploads/user.png')!=0)
			unlink($poza2);
		
		$sql=$conn->prepare("UPDATE utilizatori SET poza='uploads/user.png',grupa='N/A',detalii='',github='',publicmail=-1 WHERE username=?");
		$sql->bind_param("s",$username);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		
		$sql->close();
		$conn->close();
		return true;
	}
	
	function searchuser($info,$page,$numrows)
	{
		$infovechi=$info;
		$info='%'.$info.'%';
		$conn=connect();
		
		$sql=$conn->prepare("SELECT count(*) FROM utilizatori WHERE username LIKE ? OR (mail LIKE ? and publicmail=1) OR detalii LIKE ?");
		$sql->bind_param("sss",$info,$info,$info);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nr);
		$sql->fetch();
		$sql->free_result();
		
		$top=($page-1)*10;
		$sql=$conn->prepare("SELECT u.username,u.poza,s.nume,g.nume,u.detalii,g.serie,g.an FROM utilizatori u LEFT OUTER JOIN grupa g ON (g.id=u.grupa) LEFT OUTER JOIN specializare s ON (s.id=g.specializare) WHERE u.username LIKE ? OR (u.mail LIKE ? and u.publicmail=1) OR u.detalii LIKE ? LIMIT ?,?");
		$sql->bind_param("sssss",$info,$info,$info,$top,$numrows);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		$nr2=$sql->num_rows;
		$sql->bind_result($uname,$poza,$spec,$grup,$deta,$serie,$an);
		if ($nr2>0)
		{
			echo '<h3>Persoane gasite:</h3><div class="table-responsive"><table align="center" class="table"><tr><th>Foto:</th><th>Username:</th><th>Specializare</th><th>An</th><th>Serie</th><th>Grupa</th><th>Detalii</th>';
			while ($sql->fetch())
			{
				if ($an==-1)
					$an='N/A';
				if (empty($deta))
					$deta='N/A';
				echo '<tr><td><img width="50px" src="'.htmlspecialchars($poza).'" alt="'.htmlspecialchars($uname).'"></td><td><a href="user.php?username='.htmlspecialchars($uname).'">'.htmlspecialchars($uname).'</a></td><td>'.htmlspecialchars($spec).'</td><td>'.htmlspecialchars($an).'</td><td>'.htmlspecialchars($serie).'</td><td>'.htmlspecialchars($grup).'</td><td>'.htmlspecialchars($deta).'</td></tr>';
			}
			echo '</table></div><br>';
		}
		else
			echo '<h3>Nu au fost gasite rezultate :( </h3>';
		
		$nopages=ceil($nr/$numrows);
		$paginationright=True;
		if ($nopages>1)
		{
			echo '<br><div id="paginationmenu"> <ul class="pagination">';
			for ($i=1;$i<=$nopages;$i++)
			{
				if ($i<3 || ($i>$page-4 && $i<$page+4) || $i>$nopages-3)
				{
					$paginationright=True;
					if ($i==$page) echo '<li class="active"><a href="cautareauseri.php?info='.htmlspecialchars($infovechi).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
						else if ($i>0 && $i<=$nopages) echo '<li><a href="cautareuseri.php?info='.htmlspecialchars($infovechi).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
				}
				else if ($paginationright)
				{
					echo '<li><a href="#">...</a></li>';
					$paginationright=False;
				}
			}
			echo '</ul></div>';	
		}	
		echo '<br>';
	
		$sql->close();
		$conn->close();
	}
	
	function searchqa($info,$page,$numrows)
	{
		$infovechi=$info;
		$info='%'.$info.'%';
		$conn=connect();

		$sql=$conn->prepare("SELECT count(*) FROM qapost qa LEFT OUTER JOIN utilizatori u ON (qa.user=u.user_id) WHERE qa.subiect LIKE ? OR qa.mesaj LIKE ? OR u.username=?");
		$sql->bind_param("sss",$info,$info,$info);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nr);
		$sql->fetch();
		$sql->free_result();
		
		$top=($page-1)*10;
		$sql=$conn->prepare("SELECT qa.user,qa.date,qa.subiect,qa.mesaj,qa.grup,qa.categorie FROM qapost qa LEFT OUTER JOIN utilizatori u ON (qa.user=u.user_id) WHERE qa.subiect LIKE ? OR qa.mesaj LIKE ? OR u.username=? LIMIT ?,?");
		$sql->bind_param("sssss",$info,$info,$infovechi,$top,$numrows);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		$nr2=$sql->num_rows;
		$sql->bind_result($user,$date,$sub,$mesaj,$grup,$categorie);
		if ($nr2>0)
		{
			echo '<section id="questions" class="topcontent">';
			echo '<h3>Intrebari si raspunsuri gasite:</h3>';
			while ($sql->fetch())
			{
				echo '<article style="padding:1em" class="panel panel-default">';
				echo '<h3>'.htmlspecialchars($sub).'</h3>';
				echo '<blockquote>'.htmlspecialchars($mesaj).'</blockquote>';
				$user=getUsername($user);
				echo '<p>Autor:<a href="user.php?username='.htmlspecialchars($user).'">'.htmlspecialchars($user).'</a></p>';
				echo '<a href="raspunsuri.php?grup='.htmlspecialchars($grup).'"><h4>Vezi topic</h4></a>';
				echo '</article>';
			}
			echo '</section>';
		}
		else
			echo '<h3>Nu au fost gasite rezultate :( </h3>';
		
		$nopages=ceil($nr/$numrows);
		$paginationright=True;
		if ($nopages>1)
		{
			echo '<br><div id="paginationmenu"> <ul class="pagination">';
			for ($i=1;$i<=$nopages;$i++)
			{
				if ($i<3 || ($i>$page-4 && $i<$page+4) || $i>$nopages-3)
				{
					$paginationright=True;
					if ($i==$page) echo '<li class="active"><a href="cautareqa.php?info='.htmlspecialchars($infovechi).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
						else if ($i>0 && $i<=$nopages) echo '<li><a href="cautareqa.php?info='.htmlspecialchars($infovechi).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
				}
				else if ($paginationright)
				{
					echo '<li><a href="#">...</a></li>';
					$paginationright=False;
				}
			}
			echo '</ul></div>';	
		}	
		echo '<br>';
		
		$sql->close();
		$conn->close();
	}
	
	function searcharticole($info,$page,$numrows)
	{
		$infovechi=$info;
		$info='%'.$info.'%';
		$conn=connect();

		$sql=$conn->prepare("SELECT count(*) FROM articole WHERE titlu LIKE ? OR continut LIKE ? OR autor = ?");
		$sql->bind_param("sss",$info,$info,$info);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nr);
		$sql->fetch();
		$sql->free_result();
		
		$top=($page-1)*10;
		$sql=$conn->prepare("SELECT articol_id,titlu,continut,autor,data FROM articole WHERE titlu LIKE ? OR continut LIKE ? OR autor = ? LIMIT ?,?");
		$sql->bind_param("sssss",$info,$info,$infovechi,$top,$numrows);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		$nr2=$sql->num_rows;
		$sql->bind_result($id,$titlu,$continut,$autor,$data);
		if ($nr2>0)
		{
			echo '<section id="articles" class="topcontent">';
			echo '<h3>Articole gasite:</h3>';
			while ($sql->fetch())
			{
				echo '<article style="padding:1em" class="newsbrute panel panel-default" align="left">';
				echo '<h2><a href="articol.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2>';
				if (strlen($continut)>250)
					$continut=substr($continut,0,250).'...';
				else
					$continut=substr($continut,0,250);
				echo '<div>'.$continut.'</div>';
				echo '<p>Autor:<a href="user.php?username='.htmlspecialchars($autor).'">'.htmlspecialchars($autor).'</a></p>';
				echo '<p>Data:'.htmlspecialchars($data).'</p>';
				echo '</article>';
			}
			echo '</section>';
		}
		else
			echo '<h3>Nu au fost gasite rezultate :( </h3>';
		
		$nopages=ceil($nr/$numrows);
		$paginationright=True;
		if ($nopages>1)
		{
			echo '<br><div id="paginationmenu"> <ul class="pagination">';
			for ($i=1;$i<=$nopages;$i++)
			{
				if ($i<3 || ($i>$page-4 && $i<$page+4) || $i>$nopages-3)
				{
					$paginationright=True;
					if ($i==$page) echo '<li class="active"><a href="cautarearticole.php?info='.htmlspecialchars($infovechi).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
						else if ($i>0 && $i<=$nopages) echo '<li><a href="cautarearticole.php?info='.htmlspecialchars($infovechi).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
				}
				else if ($paginationright)
				{
					echo '<li><a href="#">...</a></li>';
					$paginationright=False;
				}
			}
			echo '</ul></div>';	
		}	
		
		echo '<br>';
		
		$sql->close();
		$conn->close();
	}

	function checkMailChangeRequest($user)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT date,id FROM schimbarimail WHERE user=?");
        $sql->bind_param("s",$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($data,$id);
        $sql->fetch();


        $cdata=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
        $t1=strtotime($cdata);
        $t2=strtotime($data);
        $seconds_diff=$t1-$t2;

        if ($seconds_diff>(3600*24))
        {
            $sql->free_result();
            $sql=$conn->prepare("DELETE FROM schimbarimail WHERE id=?");
            $sql->bind_param("i",$id);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
        }
        else
        {
            $sql->close();
            $conn->close();
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

	function changeMailRequest($user,$nmail,$omail)
    {
		if (getUserIdByMail($omail)==-1)
		{
			die("Mailul vechi nu exista");
			return false;
		}
        if (checkMailChangeRequest($user))
        {
            $conn=connect();

            $data=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
            $key=md5(uniqid(rand(), true));

            require_once 'mail.php';

            $subiect="Schimbarea adresei de mail";
            $mesaj='S-a primit o solicitare de schimbare a adresei de mail, a contului tau, '.htmlspecialchars(getUsername($user)).' de pe StudentHelper.<br><br>
            Pentru a confirma schimbarea adresei de mail accesati linkul <a href="http://localhost/mailchange.php?key='.htmlspecialchars($key).'">Acesta</a><br><br>
            Daca nu dumneavoastra ati solicitat schimbarea atunci accesati linkul <a href="http://localhost/deletemailchange.php?key='.htmlspecialchars($key).'">Acesta</a> pentru a putea face o solicitare noua<br><br>';

            $aux=mailsender($omail,$subiect,$mesaj,$user);

            if ($aux)
            {
                $sql=$conn->prepare("INSERT INTO schimbarimail (keylink,user,date,newmail) VALUES (?,?,?,?)");
                $sql->bind_param("siss",$key,$user,$data,$nmail);
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
            else
            {
                $conn->close();
                return false;
            }
        }
    }

    function destroyLink($key)
    {
        $conn=connect();

        $sql=$conn->prepare("DELETE FROM schimbarimail WHERE keylink=?");
        $sql->bind_param("s",$key);
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

    function verifyLink($key)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT user,newmail FROM schimbarimail WHERE keylink=?");
        $sql->bind_param("s",$key);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($user,$nmail);
        $sql->fetch();

        $sql->free_result();
        $sql=$conn->prepare("DELETE FROM schimbarimail WHERE keylink=?");
        $sql->bind_param("s",$key);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->free_result();
        $sql=$conn->prepare("UPDATE utilizatori SET mail=? WHERE user_id=?");
        $sql->bind_param("si",$nmail,$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

    function changePass($user,$opass,$npass)
    {
        $conn=connect();

        $opass=md5($opass);
        $npass=md5($npass);
        $sql=$conn->prepare("SELECT count(*) FROM utilizatori WHERE username=? and password=?");
        $sql->bind_param("ss",$user,$opass);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1");
            return false;
        }
        $sql->bind_result($nr);
        $sql->fetch();

        if ($nr!=1)
        {
            $sql->close();
            $conn->close();
            return false;
        }

        $sql->free_result();
        $sql=$conn->prepare("UPDATE utilizatori SET password=? WHERE username=?");
        $sql->bind_param("ss",$npass,$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2");
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }


?>
