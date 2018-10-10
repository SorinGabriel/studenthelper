<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	date_default_timezone_set("Europe/Bucharest");
	
	include_once 'connectdb.php';

    function CatExistQa($cat)
    {
        if (empty($cat))
            return false;

        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM qacat WHERE id=?");
        $sql->bind_param("i",$cat);
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

	function createCategory($name,$url)
	{
        if (empty($name))
            die("Numele nu poate fi gol <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($url))
            die("Url-ul nu poate fi gol <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
		$url=$url.".php";
		$conn=connect();

		if (file_exists("../".$url))
        {
            $conn->close();
            die("Fisierul exista deja <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql=$conn->prepare("INSERT INTO qacat (nume,page) VALUES (?,?)");
		$sql->bind_param("ss",$name,$url);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql=$conn->prepare("SELECT id FROM qacat WHERE nume=? and page=?");
		$sql->bind_param("ss",$name,$url);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($idcat);
		$sql->fetch();
		$myFile = '../'.$url;   
		$fh = fopen($myFile, 'w');  
		$stringData = file_get_contents('templatepage.txt', true);
		$stringData=str_replace('IDULCATEGORIEI',$idcat,$stringData);
		fwrite($fh, $stringData);
		
		$sql->close();
		$conn->close();
		return true;
	}
	
	function menuQA()
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nume,page FROM qacat");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nume,$page);
		while ($sql->fetch())
			echo '<li><a href="'.htmlspecialchars($page).'">'.htmlspecialchars($nume).'</a></li>';
		
		$sql->close();
		$conn->close();
	}
	
	function selectQA()
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT nume,id FROM qacat");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($nume,$id);
		echo '<select name="categorie" class="form-control" id="categorie">';
		while ($sql->fetch())
			echo '<option value="'.htmlspecialchars($id).'">'.htmlspecialchars($nume).'</option>';
		echo '</select><br><br>';
		$sql->close();
		$conn->close();
	}
	
	function deleteQAcat($id)
	{
        if (empty($id))
            die ("Categoria lipseste <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!CatExistQa($id))
            die ("Categoria nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
		$conn=connect();
		
		$sql=$conn->prepare("SELECT page FROM qacat WHERE id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($url);
		$sql->fetch();
		$sql->free_result();
		
		$sql=$conn->prepare("DELETE FROM qacat WHERE id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM ratingqa WHERE qa_id in (SELECT id FROM qapost WHERE categorie=?)");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error4 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

		$sql=$conn->prepare("DELETE FROM qapost WHERE categorie=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

		unlink('../'.$url);
		$sql->close();
		$conn->close();
		return true;
	}
	
	function newQA($subiect,$mesaj,$user,$categorie)
	{
	    if (!CatExistQa($categorie))
	        die("Categoria nu exista  <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
		$conn=connect();
		
		$sql=$conn->prepare("SELECT max(grup) FROM qapost");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($maxindex);
		$sql->fetch();
		$sql->free_result();
		$maxindex++;
		
		$data=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
		$sql=$conn->prepare("INSERT INTO qapost (user,date,subiect,mesaj,grup,categorie) VALUES (?,?,?,?,?,?)");
		$sql->bind_param("isssis",$user,$data,$subiect,$mesaj,$maxindex,$categorie);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $id=$sql->insert_id;
		
		$sql->close();
		$conn->close();

		$user=getUsername($user);
		include_once 'rating.php';
		rateQA($id,$user,10);
		
		return $maxindex;
	}
	
	function updateQA($id,$subiect,$mesaj)
	{
		include_once 'usersactions.php';
		include_once 'cosinesim.php';
		$conn=connect();
		
		$sql=$conn->prepare("SELECT	mesaj,user FROM qapost WHERE id=?");
		$sql->bind_param("i",$id);
		if (!$sql->execute())
		{
			$sql->close();
			$conn->close();
            die("Query error2");
			return false;
		}
		$sql->bind_result($mes,$user);
		$sql->fetch();
		$sql->free_result();
		
		session_start();
		$sir=checkmoderator($_SESSION['user']);
		if (getUserRole($_SESSION['user'])!=1 && $sir[1]!=1 && strcmp(getUsername($user),$_SESSION['user'])!=0)
		{
			$sql->close();
			$conn->close();
			die("Nu aveti drepturi");
			return false;
		}
		
		if (strcmp(getUsername($user),$_SESSION['user'])!=0)
		{
			$cosinesim=new cosinesim($mes,$mesaj);
			if ($cosinesim->getSimilarity()<0.5)
			{
				$sql->close();
				$conn->close();
				die("Mesajul modificat trebuie sa fie similar celui de dinainte.Incercati sa modificati mai putine cuvinte");
				return false;
			}
		}
		
		$sql=$conn->prepare("UPDATE qapost SET subiect=?,mesaj=? WHERE id=?");
		$sql->bind_param("ssi",$subiect,$mesaj,$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1");
            return false;
        }
		
		$sql->close();
		$conn->close();
		
		return true;
	}
	

	function getQaTitle($grup)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT subiect FROM qapost WHERE grup=? and date=(SELECT min(date) FROM qapost WHERE grup=?)");
        $sql->bind_param("ii",$grup,$grup);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error qa.php getQaTitle 1");
            return false;
        }
        $sql->bind_result($subiect);
        $sql->fetch();

        $sql->close();
        $conn->close();
        return $subiect;
    }

	function replyQA($grup,$mesaj,$user2)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT * FROM qapost WHERE grup=? ORDER BY date ASC");
		$sql->bind_param("i",$grup);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id,$user,$date,$subiect,$mesaj2,$grup,$categorie);
		$sql->fetch();
		$sql->free_result();
		
		$sql=$conn->prepare("INSERT INTO qapost (user,date,subiect,mesaj,grup,categorie) VALUES (?,?,?,?,?,?)");
		$data=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
		$subiect='RE:'.$subiect;
		$sql->bind_param("isssii",$user2,$data,$subiect,$mesaj,$grup,$categorie);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $id=$sql->insert_id;

        $sql->close();
        $conn->close();

		include_once 'rating.php';
		$uid=getUsername($user2);
		rateQA($id,$uid,10);
		
		return true;		
	}
	
	function deleteQA($id,$user)
	{
		include_once 'usersactions.php';
		
		$conn=connect();
		
		$sql=$conn->prepare("SELECT date,grup,user FROM qapost WHERE id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($mindat2,$grup,$user);
		$sql->fetch();
		$sql->free_result();
		
		
		$sir=checkmoderator($_SESSION['user']);
		if (getUserRole($_SESSION['user'])!=1 && $sir[1]!=1 && strcmp(getUsername($user),$_SESSION['user'])!=0)
		{
			$sql->close();
			$conn->close();
			die("Nu aveti permisiune <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
			return false;
		}
		
		$sql=$conn->prepare("SELECT min(date) FROM qapost WHERE grup=(SELECT grup FROM qapost WHERE id=?)");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($mindat);
		$sql->fetch();
		$sql->free_result();
		
		if ($mindat==$mindat2)
		{
            $sql=$conn->prepare("DELETE FROM ratingqa WHERE qa_id in (SELECT id FROM qapost WHERE grup=?)");
            $sql->bind_param("i",$grup);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error3ewq <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }

			$sql=$conn->prepare("DELETE FROM qapost WHERE grup=?");
			$sql->bind_param("i",$grup);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error4 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
		}
		else
		{
            $sql=$conn->prepare("DELETE FROM ratingqa WHERE qa_id=?");
            $sql->bind_param("i",$id);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error5 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }

			$sql=$conn->prepare("DELETE FROM qapost WHERE id=?");
			$sql->bind_param("i",$id);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error6 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
		}
		return true;
		$sql->close();
		$conn->close();
	}

	function getQAname($page)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT nume FROM qacat WHERE page=?");
        $sql->bind_param("s",$page);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($nume);
        $sql->fetch();

        $conn->close();

    }

	function showQA($categorie,$page,$criteriu)
	{
		include_once 'usersactions.php';
		$auth=checkifauth();
		$conn=connect();

		if ($auth)
			$sir=checkmoderator($_SESSION['user']);
		else 
			$sir=array(-1,-1,-1);
		$sql=$conn->prepare("SELECT count(*) FROM qapost qp WHERE qp.date=(SELECT min(date) FROM qapost WHERE grup=qp.grup) and categorie=?");
		$sql->bind_param("i",$categorie);
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
		
		$count=$nr;
		$sql=$conn->prepare("SELECT page FROM qacat WHERE id=?");
		$sql->bind_param("i",$categorie);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($pagina);
		$sql->fetch();
		$sql->free_result();		
		
		if (strcmp($criteriu,'data')==0)
			$sql=$conn->prepare("SELECT * FROM qapost qp WHERE qp.categorie=? and qp.date=(SELECT min(date) FROM qapost WHERE grup=qp.grup) ORDER BY date DESC LIMIT ?,10");
		else
			$sql=$conn->prepare("SELECT qp.id,qp.user,qp.date,qp.subiect,qp.mesaj,qp.grup,qp.categorie FROM `qapost` qp LEFT OUTER JOIN (SELECT qp.id as idqp,avg(rqa.nota) as media FROM `qapost` qp, `ratingqa` rqa WHERE rqa.qa_id=qp.id and rqa.user_id<>qp.user GROUP BY qp.id) as query ON qp.id=query.idqp WHERE qp.categorie=? and qp.date=(SELECT min(date) FROM qapost WHERE grup=qp.grup) ORDER BY query.media DESC LIMIT ?,10");
		$y=($page-1)*10;
		$sql->bind_param("ii",$categorie,$y);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id,$user,$date,$subiect,$mesaj,$grup,$categorie);
		$nr=$nr/10+1;
		if ($nr>2)
		{
			echo '<ul class="pagination" style="margin-top:1em">';
			for ($i=1;$i<=$nr;$i++)
				if ($i==$page)
					echo '<li class="active"><a href="'.htmlspecialchars($pagina).'?page='.htmlspecialchars($i).'&criteriu='.htmlspecialchars($criteriu).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
				else
					echo '<li><a href="'.htmlspecialchars($pagina).'?page='.htmlspecialchars($i).'&criteriu='.htmlspecialchars($criteriu).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
			echo '</ul>';
		}
		
		while ($sql->fetch())
		{
			echo '<div class="row" style="padding:1em"><article class="well panel panel-default">';
			$user=getUsername($user);
			if ($auth && (getUserRole($_SESSION['user'])==1 || $sir[1]==1 || strcmp($user,$_SESSION['user'])==0))
				echo '<input type="button" style="margin-top:1em" class="btn btn-link" value="Modifica QA" onclick="change(this)">';
			echo '<h3>'.htmlspecialchars($subiect).'</h3>';
			echo '<blockquote>'.htmlspecialchars($mesaj).'</blockquote>';
			echo '<input type="hidden" value="'.htmlspecialchars($id).'" id="id" name="id" class="id">';
			echo '<p class="">Autor:<a href="user.php?username='.htmlspecialchars($user).'">'.htmlspecialchars($user).'</a></p>';
			include_once 'phplib/rating.php';
			$total=getRateQA($id);
			echo '<h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>';
			echo '<a href="raspunsuri.php?grup='.htmlspecialchars($grup).'"><h3>Vezi raspunsuri</h3></a>';

			if ($auth && (getUserRole($_SESSION['user'])==1 || $sir[1]==1 || strcmp($user,$_SESSION['user'])==0))
			{
				echo '<input type="button" value="Sterge postarea" style="margin-bottom: 1em" class="btn btn-danger" onclick="deleteqa('.htmlspecialchars($id).')">';
			}
			echo '</article></div>';
		}
		if ($count==0)
			echo '<div class="row"><h3 class="col-sm-offset-3 col-sm-6">Nu exista intrebari</h3></div>';
		
		if ($nr>2)
		{
			echo '<ul class="pagination" style="margin-top:1em">';
			for ($i=1;$i<=$nr;$i++)
				if ($i==$page)
					echo '<li class="active"><a href="'.htmlspecialchars($pagina).'?page='.htmlspecialchars($i).'&criteriu='.htmlspecialchars($criteriu).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
				else
					echo '<li><a href="'.htmlspecialchars($pagina).'?page='.htmlspecialchars($i).'&criteriu='.htmlspecialchars($criteriu).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
			echo '</ul>';
		}
		
		$conn->close();
	}
	
	function getCat($grup)
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT qc.nume FROM qacat qc,qapost qp WHERE qc.id=qp.categorie and qp.grup=?");
		$sql->bind_param("i",$grup);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($numecat);
		$sql->fetch();
		
		return $numecat;
		
		$conn->close();
	}
	
	function showReplies($grup,$page)
	{
		include_once 'usersactions.php';
		$auth=checkifauth();
		$conn=connect();
		
		if ($auth)
			$sir=checkmoderator($_SESSION['user']);
		else 
			$sir=array(-1,-1,-1);
		$sql=$conn->prepare("SELECT count(*) FROM qapost WHERE grup=?");
		$sql->bind_param("i",$grup);
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
		$nr=$nr/10;
		$top=($page-1)*10;
		
		$sql=$conn->prepare("SELECT * FROM qapost WHERE grup=? ORDER BY date LIMIT ?,10");
		$sql->bind_param("ii",$grup,$top);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id,$user,$date,$subiect,$mesaj,$grup,$categorie);
		$x=0;
		while ($sql->fetch())
		{
			$x++;
			echo '<article style="padding:1em" class="panel panel-default">';
			$user=getUsername($user);
			if ($auth && (getUserRole($_SESSION['user'])==1 || $sir[1]==1 || strcmp($user,$_SESSION['user'])==0))
				echo '<input type="button" class="btn btn-link" style="margin-top:1em" value="Modifica QA" onclick="change(this)">';
			echo '<h3>'.htmlspecialchars($subiect).'</h3>';
			echo '<blockquote>'.htmlspecialchars($mesaj).'</blockquote>';
			echo '<input type="hidden" value="'.htmlspecialchars($id).'" id="id" name="id" class="id">';
			echo '<p>'.htmlspecialchars($date).'</p>';
			echo '<p>Autor:<a href="user.php?username='.htmlspecialchars($user).'">'.htmlspecialchars($user).'</a></p>';
			include_once 'phplib/rating.php';
			if ($auth)
			{
				$nota=checkRatingQA($id,$_SESSION['user']);

				echo '<h4>';
				$idd = "'" . $id . "'";
				$xx = "'" . $x . "'";
				if (!$nota)
					echo 'Cum ti se pare intrebarea/raspunsul?<select name="' . htmlspecialchars($x) . '" onchange="rate(' . htmlspecialchars($idd) . ',' . htmlspecialchars($x) . ')"><option value="">Alege nota</option><option value="1">Nota 1</option><option value="2">Nota 2</option><option value="3">Nota 3</option><option value="4">Nota 4</option><option value="5">Nota 5</option><option value="6">Nota 6</option><option value="7">Nota 7</option><option value="8">Nota 8</option><option value="9">Nota 9</option><option value="10">Nota 10</option></select>';
				else {
					echo 'Ai votat deja ';
					for ($i = 1; $i <= 10; $i++) {
						if ($i <= $nota)
							echo '<span class="glyphicon glyphicon glyphicon-star"></span>';
						else
							echo '<span class="glyphicon glyphicon-star-empty"></span>';
					}
					echo '<br>Schimba nota:<select name="' . htmlspecialchars($x) . '" onchange="rate(' . htmlspecialchars($idd) . ',' . htmlspecialchars($x) . ')">';
					for ($i = 1; $i <= 10; $i++) {
						if ($i == $nota)
							echo '<option value="' . htmlspecialchars($i) . '" selected>Nota ' . htmlspecialchars($i) . '</option>';
						else
							echo '<option value="' . htmlspecialchars($i) . '">Nota ' . htmlspecialchars($i) . '</option>';
					}
					echo '</select>';
				}
				echo '</h4>';
			}
			$total=getRateQA($id);
			echo '<h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>';
			if ($auth && (getUserRole($_SESSION['user'])==1 || $sir[1]==1 || strcmp($user,$_SESSION['user'])==0))
			{
				echo '<input type="button" style="margin-bottom:1em" class="btn btn-danger" value="Sterge postarea" onclick="deleteqa('.htmlspecialchars($id).')">';
			}
			echo '</article>';
		}
		
		if ($x==0)
			echo '<article><p>Aceasta intrebare nu a primit niciun raspuns momentan</p></article>';

		$nr=$nr+1;
		if ($nr>2)
		{
			echo '<ul class="pagination" style="margin-top:1em">';
			for ($i=1;$i<=$nr;$i++)
				if ($i==$page)
					echo '<li class="active"><a href="raspunsuri.php?grup='.htmlspecialchars($grup).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
				else
					echo '<li><a href="raspunsuri.php?grup='.htmlspecialchars($grup).'&page='.htmlspecialchars($i).'" class="pagelinks">'.htmlspecialchars($i).'</a></li>';
			echo '</ul>';
		}
		
		$conn->close();
	}
	
	function legaturiQA()
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT * FROM qacat");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id,$nume,$page);
		$x=0;
		while ($sql->fetch())
		{
			$x++;
			echo '<a href="'.htmlspecialchars($page).'">'.htmlspecialchars($nume).'</a><br>';
		}
		
		if ($x==0)
		{
			echo 'Nu exista categorii';
		}
		$sql->close();
		$conn->close();
	}
?>
