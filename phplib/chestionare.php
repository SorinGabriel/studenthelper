<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	date_default_timezone_set("Europe/Bucharest");
	
	include_once 'connectdb.php';

    function CatExist($cat)
    {
        if (empty($cat))
            return false;

        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM categorichestionare WHERE id=?");
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

    function createCategoryChest($name,$url)
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
        $sql=$conn->prepare("INSERT INTO categorichestionare (nume,page) VALUES (?,?)");
        $sql->bind_param("ss",$name,$url);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql=$conn->prepare("SELECT id FROM categorichestionare WHERE nume=? and page=?");
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
        $stringData = file_get_contents('templatepagechest.txt', true);
        $stringData=str_replace('IDULCATEGORIEI',$idcat,$stringData);
        fwrite($fh, $stringData);

        $sql->close();
        $conn->close();
        return true;
    }

    function selectCAT()
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT nume,id FROM categorichestionare");
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

    function menuChest()
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT nume,page FROM categorichestionare");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($nume,$page);
        while ($sql->fetch())
            echo '<li><a href="' . htmlspecialchars($page) . '">' . htmlspecialchars($nume) . '</a></li>';

        $sql->close();
        $conn->close();
    }

    function deleteChestCat($id)
    {
        if (empty($id))
            die ("Categoria lipseste <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!CatExist($id))
            die ("Categoria nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("SELECT page FROM categorichestionare WHERE id=?");
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

        $sql=$conn->prepare("DELETE FROM categorichestionare WHERE id=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM ratingchestionare WHERE chestionar_id in (SELECT id FROM chestionare WHERE id_cat=?)");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM rezultate WHERE id_chestionar in (SELECT id FROM chestionare WHERE id_cat=?)");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error4 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM chestionare WHERE id_cat=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error5 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        unlink('../'.$url);
        $sql->close();
        $conn->close();
        return true;
    }
    
    function showMyChest($page,$criteriu)
    {
		$username=$_SESSION['user'];
		include_once 'rating.php';
		include_once 'usersactions.php';
		$userid=getUserId($username);
		$conn=connect();
		
		$sql=$conn->prepare("SELECT count(*) FROM chestionare WHERE user_id=?");
		$sql->bind_param("i",$userid);
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
		
		$pagina="mychest.php";
		
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
		
		if (strcmp($criteriu,'data')==0)
			$sql=$conn->prepare("SELECT id,titlu,descriere,timp,data,user_id FROM chestionare WHERE user_id=? ORDER BY data DESC LIMIT ?,10");
		else
			$sql=$conn->prepare("SELECT c.id,c.titlu,c.descriere,c.timp,c.data,c.user_id FROM `chestionare` c LEFT OUTER JOIN (SELECT cc.id as idc,avg(rc.nota) as media FROM `chestionare` cc, `ratingchestionare` rc WHERE rc.chestionar_id=cc.id and rc.user_id<>cc.user_id GROUP BY cc.id) as query ON c.id=query.idc WHERE c.user_id=? ORDER BY query.media DESC LIMIT ?,10");
		$y=($page-1)*10;
		$sql->bind_param("ii",$userid,$y);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id,$titlu,$descriere,$timp,$data,$uid);
		$nrr=0;
		while ($sql->fetch())
		{
			$nrr++;
			$total=getRateChestionare($id);
			if (isset($_SESSION['user']) && !empty($_SESSION['user']))
			{				
				$user=$_SESSION['user'];
				$aux=checkIfTaken($id,$user);
                include_once 'usersactions.php';
				if ($aux)
                    echo '<div style="padding:1em" class="panel panel-default">
                <div class="row">
                
                    <div class="col-sm-7 col-sm-offset-1 col-xs-offset-1">
                    <h2><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2><small>'.htmlspecialchars($data).'</small>
                    <p>Descriere:'.htmlspecialchars($descriere).'</p>
                    </div>
                    
                    <div class="col sm-4 col-sm-offset-1 col-xs-offset-1">
                        <h4>Timp:'.htmlspecialchars($timp).'</h4>
                        <h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>
                        <h4>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h4>
                    </div>
                    
				</div>
				<div class="row">
				<div class="col-sm-11 col-sm-offset-1 col-xs-offset-1">
                    <h4>Rezultat:'.htmlspecialchars($aux[0]).'/'.htmlspecialchars($aux[1]).'</h4>
				</div>
				</div>
				    
				    </div>';
				    //echo '<div style="padding:1em" class="panel panel-default"><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a><p>Descriere:'.htmlspecialchars($descriere).'</p><br>'.htmlspecialchars($data).'<br>Timp:'.htmlspecialchars($timp).'<h5>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h5><h5>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h5>Rezultat:'.htmlspecialchars($aux[0]).'/'.htmlspecialchars($aux[1]).'</div><br>';
				else
                    echo '<div style="padding:1em" class="panel panel-default">
                <div class="row">
                
                    <div class="col-sm-7 col-sm-offset-1 col-xs-offset-1">
                    <h2><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2><small>'.htmlspecialchars($data).'</small>
                    <p>Descriere:'.htmlspecialchars($descriere).'</p>
                    </div>
                    
                    <div class="col sm-4 col-sm-offset-1 col-xs-offset-1">
                        <h4>Timp:'.htmlspecialchars($timp).'</h4>
                        <h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>
                        <h4>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h4>
                    </div>
                    
				</div>
				    
				    </div>';
				    //echo '<div style="padding:1em" class="panel panel-default"><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a><p>Descriere:'.htmlspecialchars($descriere).'</p><br>'.htmlspecialchars($data).'<br>Timp:'.htmlspecialchars($timp).'<h5>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h5><h5>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h5></div><br>';
			}
			else
                echo '<div style="padding:1em" class="panel panel-default">
                <div class="row">
                
                    <div class="col-sm-7 col-sm-offset-1 col-xs-offset-1">
                    <h2><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2><small>'.htmlspecialchars($data).'</small>
                    <p>Descriere:'.htmlspecialchars($descriere).'</p>
                    </div>
                    
                    <div class="col sm-4 col-sm-offset-1 col-xs-offset-1">
                        <h4>Timp:'.htmlspecialchars($timp).'</h4>
                        <h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>
                        <h4>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h4>
                    </div>
                    
				</div>
				    
				    </div>';
				//echo '<div style="padding:1em" class="panel panel-default"><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a><p>Descriere:'.htmlspecialchars($descriere).'</p><br>'.htmlspecialchars($data).'<br>Timp:'.htmlspecialchars($timp).'<h5>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h5><h5>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h5></div><br>';
		}
		if ($nrr==0)
			echo '<br><h4>Nu au fost gasite chestionare:(</h4><br>';
			
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
		$sql->close();
		$conn->close();		
	}

	function showChestionare($id_cat,$page,$criteriu)
	{
		include_once 'rating.php';
		$conn=connect();
		
		$sql=$conn->prepare("SELECT count(*) FROM chestionare WHERE id_cat=?");
		$sql->bind_param("i",$id_cat);
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
		
		$sql=$conn->prepare("SELECT page FROM categorichestionare WHERE id=?");
		$sql->bind_param("i",$id_cat);
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
		
		if (strcmp($criteriu,'data')==0)
			$sql=$conn->prepare("SELECT id,titlu,descriere,timp,data,user_id FROM chestionare WHERE id_cat=? ORDER BY data DESC LIMIT ?,10");
		else
			$sql=$conn->prepare("SELECT c.id,c.titlu,c.descriere,c.timp,c.data,c.user_id FROM `chestionare` c LEFT OUTER JOIN (SELECT cc.id as idc,avg(rc.nota) as media FROM `chestionare` cc, `ratingchestionare` rc WHERE rc.chestionar_id=cc.id and rc.user_id<>cc.user_id GROUP BY cc.id) as query ON c.id=query.idc WHERE c.id_cat=? ORDER BY query.media DESC LIMIT ?,10");
		$y=($page-1)*10;
		$sql->bind_param("ii",$id_cat,$y);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id,$titlu,$descriere,$timp,$data,$uid);
		$nrr=0;
		while ($sql->fetch())
		{
			$nrr++;
			$total=getRateChestionare($id);
			if (isset($_SESSION['user']) && !empty($_SESSION['user']))
			{				
				$user=$_SESSION['user'];
				$aux=checkIfTaken($id,$user);
                include_once 'usersactions.php';
				if ($aux)
                    echo '<div style="padding:1em" class="panel panel-default">
                <div class="row">
                
                    <div class="col-xs-offset-1 col-sm-7 col-sm-offset-1">
                    <h2><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2><small>'.htmlspecialchars($data).'</small>
                    <p>Descriere:'.htmlspecialchars($descriere).'</p>
                    </div>
                    
                    <div class="col-xs-offset-1 col sm-4 col-sm-offset-1">
                        <h4>Timp:'.htmlspecialchars($timp).'</h4>
                        <h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>
                        <h4>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h4>
                    </div>
                    
				</div>
				<div class="row">
				<div class="col-xs-offset-1 col-sm-11 col-sm-offset-1">
                    <h4>Rezultat:'.htmlspecialchars($aux[0]).'/'.htmlspecialchars($aux[1]).'</h4>
				</div>
				</div>
				    
				    </div>';
					//echo '<div style="padding:1em" class="panel panel-default"><h2><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2><p>Descriere:'.htmlspecialchars($descriere).'</p><br>'.htmlspecialchars($data).'<br>Timp:'.htmlspecialchars($timp).'<h5>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h5><h5>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h5>Rezultat:'.htmlspecialchars($aux[0]).'/'.htmlspecialchars($aux[1]).'</div><br>';
				else
                    echo '<div style="padding:1em" class="panel panel-default">
                <div class="row">
                
                    <div class="col-sm-7 col-sm-offset-1 col-xs-offset-1">
                    <h2><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2><small>'.htmlspecialchars($data).'</small>
                    <p>Descriere:'.htmlspecialchars($descriere).'</p>
                    </div>
                    
                    <div class="col sm-4 col-sm-offset-1 col-xs-offset-1">
                        <h4>Timp:'.htmlspecialchars($timp).'</h4>
                        <h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>
                        <h4>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h4>
                    </div>
                    
				</div>
				    
				    </div>';
					//echo '<div style="padding:1em" class="panel panel-default"><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a><p>Descriere:'.htmlspecialchars($descriere).'</p><br>'.htmlspecialchars($data).'<br>Timp:'.htmlspecialchars($timp).'<h5>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h5><h5>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h5></div><br>';
			}
			else
                echo '<div style="padding:1em" class="panel panel-default">
                <div class="row">
                
                    <div class="col-sm-7 col-sm-offset-1 col-xs-offset-1">
                    <h2><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a></h2><small>'.htmlspecialchars($data).'</small>
                    <p>Descriere:'.htmlspecialchars($descriere).'</p>
                    </div>
                    
                    <div class="col sm-4 col-sm-offset-1 col-xs-offset-1">
                        <h4>Timp:'.htmlspecialchars($timp).'</h4>
                        <h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>
                        <h4>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h4>
                    </div>
                    
				</div>
				    
				    </div>';
				//echo '<div style="padding:1em" class="panel panel-default"><a href="quiz.php?id='.htmlspecialchars($id).'">'.htmlspecialchars($titlu).'</a><p>Descriere:'.htmlspecialchars($descriere).'</p><br>'.htmlspecialchars($data).'<br>Timp:'.htmlspecialchars($timp).'<h5>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h5><h5>Postat de:<a href="user.php?username='.htmlspecialchars(getUsername($uid)).'">'.htmlspecialchars(getUsername($uid)).'</a></h5></div><br>';
		}
		if ($nrr==0)
			echo '<br><h4>Nu au fost gasite chestionare:(</h4><br>';
			
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
		$sql->close();
		$conn->close();
	}
	
	function insertChestionar($titlu,$descriere,$timp,$data,$id_cat,$user)
	{
		if (CatExist($id_cat))
		{
			$conn=connect();

			include_once 'usersactions.php';
			$user=getUserId($user);
			$date=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
			$sql=$conn->prepare("INSERT INTO chestionare (titlu,descriere,timp,data,id_cat,user_id) VALUES (?,?,?,?,?,?)");
			$sql->bind_param("ssisis",$titlu,$descriere,$timp,$date,$id_cat,$user);
			if (!$sql->execute())
			{
				$sql->close();
				$conn->close();
				die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
				return false;
			}
			$id=$sql->insert_id;

			echo count($data);
			$i=0;
			$nrintrebari=0;
			while ($i<count($data))
			{
				$intrebare=$data[$i];
				$rasp1=$data[$i+1];
				$rasp2=$data[$i+2];
				$rasp3=$data[$i+3];
				$rasp4=$data[$i+4];
				$corect=$data[$i+5];
				$sql->free_result();
				$sql=$conn->prepare("INSERT INTO intrebari (intrebare,raspuns1,raspuns2,raspuns3,raspuns4,corect,id_chestionar) VALUES (?,?,?,?,?,?,?)");
				$sql->bind_param("sssssii",$intrebare,$rasp1,$rasp2,$rasp3,$rasp4,$corect,$id);
				if (!$sql->execute())
				{
					$sql->close();
					$conn->close();
					die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
					return false;
				}
				$i+=6;
				$nrintrebari++;
			}

            $conn->close();

			registerResults($id,$user,$nrintrebari,$nrintrebari);
			include_once 'rating.php';
			$user=getUsername($user);
			rateChestionare($id,$user,10);

			return true;
		}
		else
		{
			die("Categoria nu exista");
			return false;
		}
	}
	
	function deleteChestionar($id,$uname)
	{
		include_once 'usersactions.php';
		
		$conn=connect();
		$sql=$conn->prepare("SELECT user_id FROM chestionare WHERE id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error5 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($user);
		$sql->fetch();
		$sql->free_result();
		
		$user=getUsername($user);
		
		$sir=checkmoderator($uname);
		if (getUserRole($uname)!=1 && $sir[2]!=1 && strcmp($user,$uname)!=0)
			die("Nu aveti drepturile de a sterge <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

        $sql=$conn->prepare("DELETE FROM ratingchestionare WHERE chestionar_id=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM rezultate WHERE id_chestionar=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

		$sql=$conn->prepare("DELETE FROM chestionare WHERE id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM intrebari WHERE id_chestionar=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error4 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->close();
		$conn->close();
		return true;
	}
	
	function getChestionar($id)
	{
		include_once 'rating.php';
		include_once 'usersactions.php';
		$conn=connect();
		$sql=$conn->prepare("SELECT user_id FROM chestionare WHERE id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($user);
		$sql->fetch();
		$sql->free_result();
		
		$user=getUsername($user);
	    echo '<div class="well" style="padding:3em">';
		if (isset($_SESSION['user']) && !empty($_SESSION['user']))
		{	
			$sir=checkmoderator($_SESSION['user']);
			if (getUserRole($_SESSION['user'])==1 || $sir[2]==1  || strcmp($user,$_SESSION['user'])==0)
				echo '<input type="button" class="btn btn-danger" value="Sterge chestionar" onclick="deletechestionar('.htmlspecialchars($id).')"><br>';
		}
		$variabila=false;
		if (isset($_SESSION['user']) && !empty($_SESSION['user']))
		{
			$user=$_SESSION['user'];
			$aux=checkIfTaken($id,$user);
			if ($aux)
			{
                $sql=$conn->prepare("SELECT titlu,descriere,timp,data FROM chestionare WHERE id=?");
                $sql->bind_param("i",$id);
                if (!$sql->execute())
                {
                    $sql->close();
                    $conn->close();
                    die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                    return false;
                }
                $sql->bind_result($titlu,$descriere,$timp,$data);
                $sql->fetch();

                echo '<h2>'.$titlu.'<small>    (Postat pe: '.$data.')</small></h2>';
                echo '<h3>Descriere: '.$descriere.'</h3>';
                echo '<h3>Timp:<p id="time">'.htmlspecialchars($timp).'</p></h3>';

                $sql->free_result();

				$variabila=true;
				if ($aux[0]/$aux[1]==1)
                    echo '<h4 style="background-color:green;color:black;padding:1em">Ati rezolvat deja chestionarul si ati obtinut un scor de '.htmlspecialchars($aux[0]).' din '.htmlspecialchars($aux[1]).' intrebari.</h4>';
                else if ($aux[0]/$aux[1]>=0.75)
                    echo '<h4 style="background-color:blue;color:black;padding:1em">Ati rezolvat deja chestionarul si ati obtinut un scor de '.htmlspecialchars($aux[0]).' din '.htmlspecialchars($aux[1]).' intrebari.</h4>';
                else if ($aux[0]/$aux[1]>=0.5)
                    echo '<h4 style="background-color:yellow;color:black;padding:1em">Ati rezolvat deja chestionarul si ati obtinut un scor de '.htmlspecialchars($aux[0]).' din '.htmlspecialchars($aux[1]).' intrebari.</h4>';
                else
                    echo '<h4 style="background-color:red;color:black;padding:1em">Ati rezolvat deja chestionarul si ati obtinut un scor de '.htmlspecialchars($aux[0]).' din '.htmlspecialchars($aux[1]).' intrebari.</h4>';
			
				$sql=$conn->prepare("SELECT * FROM intrebari WHERE id_chestionar=?");
				$sql->bind_param("i",$id);
				if (!$sql->execute())
				{
					$sql->close();
					$conn->close();
					die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
					return false;
				}
				$sql->bind_result($id_intrebare,$intrebare,$rasp1,$rasp2,$rasp3,$rasp4,$corect,$id_chest);
				$i=1;
				while ($sql->fetch())
				{
					echo '<div class="intrebare">';
					echo '<h4>'.htmlspecialchars($intrebare).'</h4>';
					if ($corect==1)	echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="1" disabled readonl><span class="1" style="background-color:green">'.htmlspecialchars($rasp1).'</span><br>';
						else echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="1" disabled readonl><span class="1">'.htmlspecialchars($rasp1).'</span><br>';
					if ($corect==2)	echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="2" disabled readonl><span class="2" style="background-color:green">'.htmlspecialchars($rasp1).'</span><br>';
						else echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="2" disabled readonl><span class="2">'.htmlspecialchars($rasp2).'</span><br>';
					if ($corect==3)	echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="3" disabled readonl><span class="3" style="background-color:green">'.htmlspecialchars($rasp1).'</span><br>';
						else echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="3" disabled readonl><span class="3">'.htmlspecialchars($rasp3).'</span><br>';
					if ($corect==4)	echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="4" disabled readonl><span class="4" style="background-color:green">'.htmlspecialchars($rasp1).'</span><br>';
						else echo '<input type="radio" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="4" disabled readonl><span class="4">'.htmlspecialchars($rasp4).'</span><br>';
					echo '</div>';
					$i++;
				}
			
			}
			if ($variabila)
			{
				$nota=checkRatingChestionare($id,$_SESSION['user']);

				$sql=$conn->prepare("SELECT count(*) FROM chestionare WHERE user_id=? and id=?");
				$uid=getUserId($_SESSION['user']);
				$sql->bind_param("ii",$uid,$id);
				$sql->execute();
				$sql->bind_result($nrverif);
				$sql->fetch();

				if ($nrverif==0) {

                    echo '<h4>';
                    $idd="'".$id."'";
                    if (!$nota)
                        echo 'Inca nu ai votat!<select id="rate" onchange="rate('.htmlspecialchars($idd).')"><option value="">Alege nota</option><option value="1">Nota 1</option><option value="2">Nota 2</option><option value="3">Nota 3</option><option value="4">Nota 4</option><option value="5">Nota 5</option><option value="6">Nota 6</option><option value="7">Nota 7</option><option value="8">Nota 8</option><option value="9">Nota 9</option><option value="10">Nota 10</option></select>';
                    else
                    {
                        echo 'Ai votat deja ';
                        for ($i=1;$i<=10;$i++)
                        {
                            if ($i<=$nota)
                                echo '<span class="glyphicon glyphicon glyphicon-star"></span>';
                            else
                                echo '<span class="glyphicon glyphicon-star-empty"></span>';
                        }
                        echo '<br>Schimba nota:<select id="rate" onchange="rate('.htmlspecialchars($idd).')">';
                        for ($i=1;$i<=10;$i++)
                        {
                            if($i==$nota)
                                echo '<option value="'.htmlspecialchars($i).'" selected>Nota '.htmlspecialchars($i).'</option>';
                            else
                                echo '<option value="'.htmlspecialchars($i).'">Nota '.htmlspecialchars($i).'</option>';
                        }
                        echo '</select>';
                    }
                    echo '</h4>';

                }
				
				$total=getRateChestionare($id);
				echo '<h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>';
			}
		}	
		if (!$variabila)
		{
		
		$sql=$conn->prepare("SELECT titlu,descriere,timp,data FROM chestionare WHERE id=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($titlu,$descriere,$timp,$data);
		$sql->fetch();
		
		echo '<h2>'.$titlu.'<small>    (Postat pe: '.$data.')</small></h2>';
		echo '<h3>Descriere: '.$descriere.'</h3>';
		echo '<h3>Timp:<p id="time">'.htmlspecialchars($timp).'</p></h3>';
		echo '<h3><input type="button" id="startbut" value="Start" class="btn btn-primary" onclick="takequiz()"></h3>';
		echo '<input type="hidden" value="'.htmlspecialchars($id).'" id="idul">';

		$sql->free_result();

		$sql=$conn->prepare("SELECT * FROM intrebari WHERE id_chestionar=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($id_intrebare,$intrebare,$rasp1,$rasp2,$rasp3,$rasp4,$corect,$id_chest);
		$i=1;
		while ($sql->fetch())
        {
            echo '<div class="intrebare" style="display:none">';
            echo '<h4>'.htmlspecialchars($intrebare).'</h4>';
            echo '<input type="radio" id="raspunsi'.htmlspecialchars($i).'1" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="1"><label style="font-weight:normal" for="raspunsi'.htmlspecialchars($i).'1" class="1">'.htmlspecialchars($rasp1).'</label><br>';
            echo '<input type="radio" id="raspunsi'.htmlspecialchars($i).'2" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="2"><label style="font-weight:normal" for="raspunsi'.htmlspecialchars($i).'2" class="2">'.htmlspecialchars($rasp2).'</label><br>';
            echo '<input type="radio" id="raspunsi'.htmlspecialchars($i).'3" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="3"><label style="font-weight:normal" for="raspunsi'.htmlspecialchars($i).'3" class="3">'.htmlspecialchars($rasp3).'</label><br>';
            echo '<input type="radio" id="raspunsi'.htmlspecialchars($i).'4" class="raspunsi'.htmlspecialchars($i).'" name="raspunsi'.htmlspecialchars($i).'" value="4"><label style="font-weight:normal" for="raspunsi'.htmlspecialchars($i).'4" class="4">'.htmlspecialchars($rasp4).'</label><br>';
            echo '</div>';
            $i++;
        }

		echo '<h4 id="rezultate"></h4>';
		echo '<input style="display:none" class="btn btn-danger" id="finish" type="button" value="Am terminat" onclick="evaluareexamen()">';
		
		if (isset($_SESSION['user']) && !empty($_SESSION['user']))
		{
			$nota=checkRatingChestionare($id,$_SESSION['user']);
			echo '<div id="ratethisquiz" style="display:none">';
			echo '<h4>';
			$idd="'".$id."'";
			if (!$nota)
				echo 'Inca nu ai votat!<select id="rate" onchange="rate('.htmlspecialchars($idd).')"><option value="">Alege nota</option><option value="1">Nota 1</option><option value="2">Nota 2</option><option value="3">Nota 3</option><option value="4">Nota 4</option><option value="5">Nota 5</option><option value="6">Nota 6</option><option value="7">Nota 7</option><option value="8">Nota 8</option><option value="9">Nota 9</option><option value="10">Nota 10</option></select>';
			else
			{
				echo 'Ai votat deja ';
				for ($i=1;$i<=10;$i++)
				{
					if ($i<=$nota)
						echo '<span class="glyphicon glyphicon glyphicon-star"></span>';
					else
						echo '<span class="glyphicon glyphicon-star-empty"></span>';
				}
				echo '<br>Schimba nota:<select id="rate" onchange="rate('.htmlspecialchars($idd).')">';
				for ($i=1;$i<=10;$i++)
				{
					if($i==$nota)
						echo '<option value="'.htmlspecialchars($i).'" selected>Nota '.htmlspecialchars($i).'</option>';
					else 
						echo '<option value="'.htmlspecialchars($i).'">Nota '.htmlspecialchars($i).'</option>';
				}
				echo '</select>';
			}			
			echo '</h4>';
			$total=getRateChestionare($id);
			echo '<h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4>';
			echo '</div>';
		}
		echo '</div>';
		$sql->close();
		$conn->close();
		}
	}

	function getAnswers($id)
	{
		$conn=connect();

        $answers=array();
		$sql=$conn->prepare("SELECT corect FROM intrebari WHERE id_chestionar=?");
		$sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($corect);
		while ($sql->fetch()) {
            array_push($answers, $corect);
        }

		$sql->close();
		$conn->close();
		
		return $answers;
	}
	
	function registerResults($id,$user,$corecte,$total)
	{
		$conn=connect();
		
		$date=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
		$sql=$conn->prepare("INSERT INTO rezultate (id_chestionar,id_user,data,corecte,total) VALUES (?,?,?,?,?)");
		$sql->bind_param("iisii",$id,$user,$date,$corecte,$total);
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
	
	function checkIfTaken($id,$user)
	{
		include_once 'usersactions.php';
		$user=getUserId($user);
		$conn=connect();
		
		$sql=$conn->prepare("SELECT corecte,total FROM rezultate WHERE id_chestionar=? and id_user=?");
		$sql->bind_param("ii",$id,$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->store_result();
		if ($sql->num_rows()>0) 
		{
			$sql->bind_result($corecte,$total);
			$sql->fetch();
			$sql->close();
			$conn->close();
			$rezultat=array();
			array_push($rezultat,$corecte,$total);
			return $rezultat;
		}
		else
			return false;
	}

    function legaturiChest()
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT * FROM categorichestionare");
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

    function chestionarTitle($id)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT titlu,timp FROM chestionare WHERE id=?");
        $sql->bind_param("i",$id);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($titlu,$timp);
        $sql->fetch();

        $sql->close();
        $conn->close();

        return array($titlu,$timp);
    }
	
?>
