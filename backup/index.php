<!DOCTYPE html>
<html>

<head><title>Unealta studentului</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Marica Sorin">
<meta name="title" content="Unealta studentului">
<meta name="description" content="O unealta pentru studentul de pretutindeni">
<meta http-equiv="Content-Type" content="text.php; charset=utf-8" />
<!-- bootstrap -->
<link rel="stylesheet" href="styles/bs/css/bootstrap.min.css">
<script src="styles/jquery.min.js"></script>
<script src="styles/bs/js/bootstrap.min.js"></script>
<!-- end bootstrap -->
<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light|Montserrat|Quicksand|Fredoka+One' rel='stylesheet' type='text/css'>
<script src="javascripts/scripts.js"></script>
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
	<li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span>Acasa</a></li> <!--O combinatie intre toate -->
	<li><a href="noutati.php"><span class="glyphicon glyphicon-bullhorn"></span>Noutati</a></li> <!--Stiri si informatii de la secretariat -->
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

<section id="mesajdeintampinare" class="row jumbotron">
<div class="col-sm-6 col-sm-offset-3">
<?php 

if ($auth)
{
    echo '<h3 style="text-align:center"><img style="height:100px" src="';
	getUserphoto($_SESSION['user']);
	echo '" alt="'.htmlspecialchars($_SESSION['user']).'"></h3>';
	echo '<h4 style="text-align:center"><a href="profile.php">Panoul utilizatorului</a></h4>';
	$userrole=getUserRole($_SESSION['user']);

	if ($userrole==1)
		echo '<h4 style="text-align:center"><a href="admin.php">Panoul administratorului</a></h4>';
}
?>
    <br>
<h2>Bun venit pe StudentHelper.Ro<?php if ($auth) echo ', '.htmlspecialchars($_SESSION['user']);?></h2><br>
<?php if (!$auth) : ?>
<p>Aici vei gasi articole legate de facultatea ta,informatii despre evenimente ce urmeaza a fi organizate precum si accesul la interactiunea
cu alti studenti</p>
<?php endif ?>
</div>
</section>

<?php
	if (!$auth)
	echo '
<section id="conectare" align="center" class="row well">
<div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
<div class="panel panel-default">
<h3>Conecteaza-te</h3>
<div class="panel-body">
<form method="post" action="conectare.php">
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		<input type="text" class="form-control" name="user" id="utilizator" placeholder="Utilizator">
	</div><br>
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		<input type="password" name="pass" class="form-control" placeholder="Parola" id="password">
	</div>
	<p id="ajaxanswer"></p>
	<script src="javascripts/ajax.js"></script>
	<input type="button" onclick="conectUser()" class="btn btn-primary" value="Conecteaza-te">
</form><br>
<h4>Nu ai cont? <a href="inregistrare.php">Inregistreaza-te!</a></h4>
<h5><a href="lostpassword.php">Am uitat parola</a></h5>
</div>
</div>
</section>';
?>

<footer class="well" style="background-color:black;color:white">
<h4>Created by Sorin Marica</h4>
</footer>

</body>

</html>