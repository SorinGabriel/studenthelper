<!DOCTYPE html>
<html>

<head><title>Utilizator</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Acasa</a></li> <!--O combinatie intre toate -->
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

    <div class="row">
<section id="mesajdeintampinare" align="center" class="col-sm-6 col-sm-offset-3">
<?php
	if (isset($_GET['username']) && !empty($_GET['username']) && getUserId($_GET['username'])!=-1)
		$user=$_GET['username'];
	else
		header('Location: /');

    echo '<h3 style="text-align:center"><img style="height:100px" src="';
    getUserphoto($user);
    echo '" alt="'.htmlspecialchars($user).'"></h3>';
	echo '<h2>'.htmlspecialchars($user).'</h2>';
	echo '<h3>Facultate:'.htmlspecialchars(getFac($user)).'</h3>';
	echo '<h3>An:'.htmlspecialchars(getAn($user)).'</h3>';
	echo '<h3>Serie:'.htmlspecialchars(getSerie($user)).'</h3>';
	echo '<h3>Grupa:'.htmlspecialchars(getGrupa($user)).'</h3>';
	echo '<h3>Specializare:'.htmlspecialchars(getSpecializare($user)).'</h3>';
	echo '<h3>Mail:'.htmlspecialchars(getMail($user)).'</h3>';
	echo '<h3>Github:';
	if (strcmp(getGit($user),"N/A")==0) echo 'N/A</h3>';
	    else echo '<a target="_blank" href="'.htmlspecialchars(getGit($user)).'">'.htmlspecialchars(getGit($user)).'</a></h3>';
	echo '<h3>Detalii:'.htmlspecialchars(getDetalii($user)).'</h3>';

?>
</section>
    </div>

    <footer class="well" style="background-color:black;margin-top:3em;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</div>
</body>

</html>
