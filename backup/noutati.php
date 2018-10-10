<!DOCTYPE html>
<html>

<head><title>Articole</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Marica Sorin">
<meta name="title" content="Unealta studentului">
<meta name="description" content="O unealta pentru studentul de pretutindeni">
<meta http-equiv="Content-Type" content="text.php; charset=utf-8" />
<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light|Montserrat|Quicksand' rel='stylesheet' type='text/css'>
<script src="javascripts/scripts.js"></script>
<!-- bootstrap -->
<link rel="stylesheet" href="styles/bs/css/bootstrap.min.css">
<script src="styles/jquery.min.js"></script>
<script src="styles/bs/js/bootstrap.min.js"></script>
<!-- end bootstrap -->
</head>

<body>
<div class="container-fluid">
<?php
	include_once 'phplib/usersactions.php';
	include_once 'phplib/rating.php';
	
	$auth=checkifauth();
?>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><div draggable="true" ondrag="blush(event)">Student tool</div></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <form action="cautare.php" method="GET" class="navbar-form navbar-left">
                    <div class="input-group">
                        <input name="info" type="text" class="form-control" placeholder="Cautare">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Acasa</a></li> <!--O combinatie intre toate -->
                    <li class="active"><a href="noutati.php"><span class="glyphicon glyphicon-bullhorn"></span>Noutati</a></li> <!--Stiri si informatii de la secretariat -->
                    <li><a href="orar.php"><span class="glyphicon glyphicon-list-alt"></span>Orar</a></li> <!-- Poti vedea atat orarul facultatii cat si sa iti creezi propriul orar vazut doar de tine -->
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="qanda.php"><span class="glyphicon glyphicon-question-sign"></span>Q&A</a>
                        <ul class="dropdown-menu">
                            <?php
                            include_once 'phplib/qa.php';

                            menuQA();
                            ?>
                        </ul>
                    </li> <!-- Pagina unde poti intreba si primii raspunsuri -->
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="examen.php"><span class="glyphicon glyphicon-education"></span>Chestionare</a>
                        <ul class="dropdown-menu">
                            <?php
                            include_once 'phplib/chestionare.php';

                            menuChest();
                            ?>
                        </ul>
                    </li> <!-- Pagina cu quizuri pt examene -->
                    <?php
                    if ($auth)
                        echo '<li><a href="phpscripts/deconectare.php"><span class="glyphicon glyphicon-off"></span>Deconectare</a></li>';
                    ?>
                </ul>
            </div>
        </div>
    </nav>

<section class="row">
    <div class="col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
		<br>
<?php
	if ($auth)
		$sir=checkmoderator($_SESSION['user']);
	else 
		$sir=array(-1,-1,-1);
	echo '<h4><ul class="nav nav-pills">';
	if ($auth && (getUserRole($_SESSION['user'])==1 || $sir[0]==1))
		echo '<li><a href="publish.php">Creeaza articol</a></li>';
	$page=1;
	if (isset($_GET['pagina']) && !empty($_GET['pagina']))
		$page=$_GET['pagina'];
	
	$order="data";
	if (isset($_GET['order'])&& !empty($_GET['order']))
		$order=$_GET['order'];
		
	if (strcmp($order,'votes')==0)
		echo '<li><a href="noutati.php?order=data">Ordoneaza dupa data</a></li>';
	else
		echo '<li><a href="noutati.php?order=votes">Ordoneaza dupa voturi</a></li>';
	echo '</ul></h4><br>';
	
	$conn=connect();
	$sql=$conn->prepare("SELECT count(*) FROM `articole`");
	$sql->execute();
	$sql->bind_result($nr);
	$sql->fetch();
	$nopages=ceil($nr/10);
	$paginationright=True;
	if ($nopages>1 && $page>1)
	{
		echo '<ul class="pagination">';
		for ($i=1;$i<=$nopages;$i++)
		{
			if ($i<3 || ($i>$page-4 && $i<$page+4) || $i>$nopages-3)
			{
				$paginationright=True;
				if ($i==$page) echo '<li class="active"><a href="noutati.php?pagina='.htmlspecialchars($i).'&order='.htmlspecialchars($order).'">'.htmlspecialchars($i).'</a></li>';
					else if ($i>0 && $i<=$nopages) echo '<li><a href="noutati.php?pagina='.htmlspecialchars($i).'&order='.htmlspecialchars($order).'">'.htmlspecialchars($i).'</a></li>';
			}
			else if ($paginationright)
			{
				echo '<li><a href="#">...</a></li>';
				$paginationright=False;
			}
		}
		echo '</ul>';
	}
	
	$start=($page-1)*10;
	$sql->free_result();
	if (strcmp($order,"votes")==0)
		$sql=$conn->prepare("SELECT a.articol_id,a.titlu,a.continut,a.autor,a.data FROM `articole` a LEFT OUTER JOIN (SELECT aa.articol_id as idart,avg(ra.nota) as media FROM `articole` aa, `ratingarticole` ra WHERE ra.articol_id=aa.articol_id GROUP BY aa.articol_id) as query ON a.articol_id=query.idart ORDER BY query.media DESC LIMIT ?,10");
	else
		$sql=$conn->prepare("SELECT * FROM `articole` ORDER BY data DESC LIMIT ?,10");
	$sql->bind_param('i',$start);
	$sql->execute();
	$sql->store_result();
	if ($sql->num_rows==0)
		echo '<h3>Nu exista rezultate</h3><br><br>';
	$sql->bind_result($aid,$titlu,$continut,$autor,$data);
	while ($sql->fetch())
	{
		$continut=substr($continut,0,1000);
        $total=getRateArt($aid);
		echo '<article class="newsbrute">';
		echo '
		<div class="panel panel-default">
		  <div class="panel-heading"><h3><a href="articol.php?id='.htmlspecialchars($aid).'">'.htmlspecialchars($titlu).'</a><small> <p>Postat de: <a href="user.php?username='.htmlspecialchars($autor).'">'.htmlspecialchars($autor).'</a> la data:'.htmlspecialchars($data).' </p></small></h3></div>
		  <div class="panel-body">'.substr($continut,0,1000).'</div>
		  <div class="panel-footer"><h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4></div>
		</div>';
		echo '</article>';
	}
	

	$paginationright=True;
	if ($nopages>1)
	{
		echo '<br><ul class="pagination">';
		for ($i=1;$i<=$nopages;$i++)
		{
			if ($i<3 || ($i>$page-4 && $i<$page+4) || $i>$nopages-3)
			{
				$paginationright=True;
				if ($i==$page) echo '<li class="active"><a href="noutati.php?pagina='.htmlspecialchars($i).'">'.htmlspecialchars($i).'</a></li>';
					else if ($i>0 && $i<=$nopages) echo '<li><a href="noutati.php?pagina='.htmlspecialchars($i).'">'.htmlspecialchars($i).'</a></li>';
			}
			else if ($paginationright)
			{
				echo '<li><a href="#">...</a></li>';
				$paginationright=False;
			}
		}
		echo '</ul>';
	}	
	
	$sql->close();
	$conn->close();
?>
    </div>
</section>

    <footer class="well" style="background-color:black;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</body>

</html>
