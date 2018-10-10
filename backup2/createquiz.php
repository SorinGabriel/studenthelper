<!DOCTYPE html>
<html>

<head><title>Adaugare quiz</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<script src="javascripts/chestionare.js"></script>
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

<section class="topcontent col-sm-offset-3 col-sm-6 input-group"  id="formpreg" style="margin-top:5em">
<h3>Creare chestionar</h3>
    <form method="post" action="phpscripts/createquiz.php" onsubmit="return validate()">
<label for="titlu">Titlu chestionar</label><input type="text" class="form-control" id="titlu" name="titlu"><br>
<label for="descriere">Descriere chestionar</label><textarea id="descriere" class="form-control" name="descriere"></textarea><br>
<label for="timp">Timp chestionar(in secunde)</label><input type="number" id="timp" class="form-control" name="timp"><small>3600 secunde=1 ora </small><br>
<label for="categorie">Categorie chestionar</label><?php include_once 'phplib/chestionare.php'; selectCAT(); ?>
<div id="intrebari">
<i>Bifati raspunsul corect</i><br><br>
<div class="intrebare" id="intrebare1">
<label for="intrebare1">Intrebare:</label><input type="text" name="intrebare1" placeholder="Intrebare" class="form-control" id="intrebare1"><br><br><br>
<input type="radio" value="1" name="raspunsi1"><input type="text" name="rasp1i1" placeholder="Raspunsul 1" id="rasp1i1"><br>
<input type="radio" value="2" name="raspunsi1"><input type="text" name="rasp2i1" placeholder="Raspunsul 2" id="rasp2i1"><br>
<input type="radio" value="3" name="raspunsi1"><input type="text" name="rasp3i1" placeholder="Raspunsul 3" id="rasp3i1"><br>
<input type="radio" value="4" name="raspunsi1"><input type="text" name="rasp4i1" placeholder="Raspunsul 4" id="rasp4i1"><br>
</div><br>
<input type="button" onclick="addquestion()" class="btn btn-default" value="Adauga intrebare" id="adaugaintrebare"><br><br>
    <input type="hidden" value="1" name="numarintrebari" id="numarintrebari">
<input type="submit" class="btn btn-primary" value="Trimite"><br><br>
</div>
</form>
</section>

    <footer class="well" style="background-color:black;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</div>

</body>

</html>