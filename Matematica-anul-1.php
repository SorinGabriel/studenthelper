<!DOCTYPE html>
<html>

<head><title>Unealta studentului - Categorie chestionare</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Marica Sorin">
<meta name="title" content="Unealta studentului">
<meta name="description" content="O unealta pentru studentul de pretutindeni">
<meta http-equiv="Content-Type" content="text.php; charset=utf-8" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="styles/bs/css/bootstrap.min.css">
    <script src="styles/jquery.min.js"></script>
    <script src="styles/bs/js/bootstrap.min.js"></script>
    <!-- end bootstrap -->
<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light|Montserrat|Quicksand' rel='stylesheet' type='text/css'>
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
                    <li class="active dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="examen.php"><span class="glyphicon glyphicon-education"></span>Chestionare</a>
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
<section class="topcontent col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8" id="formpreg">
<h3>Chestionare:</h3>
<h4><ul class="nav nav-pills">
<?php if ($auth):?>
    <li><a href="createquiz.php">Creeaza un chestionar</a></li>
    <li><a href="mychest.php">Chestionarele mele</a></li>
<?php
endif;


$criteriu="data";
if (isset($_GET['criteriu'])&& !empty($_GET['criteriu']))
	$criteriu=$_GET['criteriu'];
if (strcmp($criteriu,'data')==0)
	echo '<li><a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?criteriu=votes">Ordoneaza dupa voturi</a></li>';
else
	echo '<li><a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?criteriu=data">Ordoneaza dupa data</a></li>';

echo '</ul></h4>';

include_once 'phplib/chestionare.php';

if ($auth)
{
    include_once 'phplib/NBCFchest.php';

    $uname=$_SESSION['user'];
    $uid=getUserId($uname);

    $x=new nbcfchest(5);
    $x->setPredictions($uid);
    $x->getPredictions($uid,5);
    echo '<br>';
}

if (isset($_GET['page'])) $page=$_GET['page'];
	else $page=1;

showChestionare(4,$page,$criteriu);
?>
</section>
</div>

<footer class="well" style="background-color:black;color:white">
    <h4>Created by Sorin Marica</h4>
</footer>

</div>
</body>

</html>
