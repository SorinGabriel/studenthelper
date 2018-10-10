<!DOCTYPE html>
<html>

<head><title>Articol</title>
<!-- metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Marica Sorin">
<meta name="title" content="Unealta studentului">
<meta name="description" content="O unealta pentru studentul de pretutindeni">
<meta http-equiv="Content-Type" content="text.php; charset=utf-8" />
<!-- end metas -->
<!-- css and js -->
<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light|Montserrat|Quicksand' rel='stylesheet' type='text/css'>
<script src="javascripts/scripts.js"></script>
<!-- end css and js -->
<!-- bootstrap -->
<link rel="stylesheet" href="styles/bs/css/bootstrap.min.css">
<script src="styles/jquery.min.js"></script>
<script src="styles/bs/js/bootstrap.min.js"></script>
<!-- end bootstrap -->
<!-- jquery scripts -->
<script src="javascripts/articole.js"></script>
<!-- jquery -->
</head>

<body>
<div class="container-fluid">
<?php
	include_once 'phplib/usersactions.php';
	
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

<article class="col-xs-12 col-sm-8 col-sm-offset-2" style="padding-top:5%">
<?php
	
	if (!isset($_GET['id']) || empty($_GET['id']))
		echo 'Nu e niciun articol aici';
	else
	{
		$id=$_GET['id'];
		$conn=connect();
		$sql=$conn->prepare("SELECT * FROM `articole` WHERE articol_id=?");
		$sql->bind_param("i",$id);
		$sql->execute();
		$sql->bind_result($aid,$titlu,$content,$autor,$data);
		$sql->fetch();
		echo '	<div class="panel panel-default">
				  <div class="panel-heading"><h3 align="center">'.htmlspecialchars($titlu).'</h3></div>
				  <div class="panel-body" style="padding:2em">'.$content.'</div>
				  <div class="panel-footer"><p>Postat de: <a href="user.php?username='.htmlspecialchars($autor).'">'.htmlspecialchars($autor).'</a> la data: '.htmlspecialchars($data).'<br>';
		if ($auth)
			$sir=checkmoderator($_SESSION['user']);
		else 
			$sir=array(-1,-1,-1);
		if ($auth && (getUserRole($_SESSION['user'])==1 || $sir[0]==1))
		{
			echo '<input type="hidden" value="'.htmlspecialchars($id).'" id="idarticol">';
			echo '<input type="hidden" value="'.htmlspecialchars($_SESSION['user']).'" id="user">';
			echo '<p id="mesajstergere"></p>';
			echo '<input type="button" value="Sterge articol" onclick="deletearticle()" class="btn-link"><br><a href="modifyarticle.php?id='.htmlspecialchars($id).'">Modifica articol</a>';
		}		  
		echo '</div>
				</div>';
		echo '<div class="row"><div class="col-sm-6">';
		include_once 'phplib/rating.php';
		if ($auth)
		{
			$nota=checkRatingArt($id,$_SESSION['user']);
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
				echo '<br>Schimba nota:<select id="rate" onchange="rate('.$idd.')">';
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
		$total=getRateArt($id);
		echo '<h4>Nota totala:'.htmlspecialchars($total[0]).'/'.htmlspecialchars($total[1]).' voturi</h4><br>';
		echo '</div></div>';
		$sql->close();
		$conn->close();
	}
?>
</article>

<?php 
	include_once 'phplib/articles.php';
	getComments($id);
?>

<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <?php if ($auth): ?>
            <h4 id="succesmessage"></h4>
            <div class="form-group">
                <label for="comment"><h4>Comenteaza:</h4></label>
                <textarea class="form-control" rows="5" id="comment"></textarea>
            </div>
            <input type="button" class="btn btn-info" onclick="postcomment(<?php echo htmlspecialchars($id); ?>)" value="Adauga comentariu">
        <?php endif ?>
    </div>
</div>
<br>
    <footer class="well" style="background-color:black;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</div>
</body>

</html>
