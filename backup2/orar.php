<!DOCTYPE html>
<html>

<head><title>Orar</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<script src="javascripts/facilities.js"></script>
    <style>
        @media screen and (min-width: 480px) {
            .specialbr {
                display:none;
            }
        }

        .checkbox {
            text-align:left;
        }
    </style>
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
                    <li class="active"><a href="orar.php"><span class="glyphicon glyphicon-list-alt"></span>Orar</a></li> <!-- Poti vedea atat orarul facultatii cat si sa iti creezi propriul orar vazut doar de tine -->
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

<div class="row well">
<section class="topcontentorar col-sm-2 col-sm-offset-1 col-xs-12" id="menuorar">
    <h2>Alege:</h2>
<form>
    <?php
    if ($auth) 
		$grupa=getGrupa($_SESSION['user']);
	else 
		$grupa='Necunoscuta';
		
    if (strcmp($grupa,"Necunoscuta")==0) :
        ?>
        <div class="input-group">
            <label for="facultate">Facultate:</label>
            <?php
            include_once 'phplib/facilities.php';

            selectFac();
            ?>
        </div><br>
        <div class="input-group" id="specDiv" style="display:none">
            <label for="specializare">Specializare:</label>
        </div><br id="brspec" style="display:none">
        <div class="input-group" id="groupDiv" style="display:none">
            <label for="grupa">Grupa:</label>
        </div><br id="brgrup" style="display:none">
        <?php
    else :
        ?>
        <div class="input-group">
            <label for="facultate">Facultate:</label>
            <?php include_once 'phplib/facilities.php'; selectFac(getFacId($_SESSION['user'])); ?>
        </div><br>
        <div class="input-group" id="specDiv">
            <label for="specializare">Specializare:</label>
            <span id="aux"><?php selectSpec(getFacId($_SESSION['user']),getSpecializareId($_SESSION['user'])); ?></span>
        </div><br id="brspec">
        <div class="input-group" id="groupDiv">
            <label for="grupa">Grupa:</label>
            <span id="aux2"><?php selectGroups(getSpecializareId($_SESSION['user']),getGrupaId($_SESSION['user'])); ?></span>
        </div><br id="brgrup">
        <?php
    endif
    ?>
</form>
</section>

<section class="topcontentorar col-sm-7 col-sm-offset-1 col-xs-12" id="orarblock">
<h2>Orarul facultatii</h2> 
<img src="<?php if ($auth) {if (getGrupaId($_SESSION['user'])==-1) echo 'images/emptyorar.png'; else echo htmlspecialchars(getOrar(getGrupaId($_SESSION['user'])));} else echo 'images/emptyorar.png'; ?>" alt="orar" style="width:100%" id="orar">
</section>

</div>

<div class="row well">
<section id="smartorarblock" class="col-sm-10 col-sm-offset-1">
<h3 style="text-align: center">Personalizeaza-ti propriul orar</h3><br>
<form class="form-inline" style="text-align: center">
    <div class="row">
        <div class="addevent form-group col-xs-4 col-sm-3">
            <h4>Zi:</h4>
            <div class="checkbox"><label><input type="checkbox" name="zi" value="60">Luni</label></div>
            <div class="checkbox"><label><input type="checkbox" name="zi" value="154">Marti</label></div>
            <div class="checkbox"><label><input type="checkbox" name="zi" value="248">Miercuri</label></div>
            <div class="checkbox"><label><input type="checkbox" name="zi" value="342">Joi</label></div>
            <div class="checkbox"><label><input type="checkbox" name="zi" value="436">Vineri</label></div>
        </div>
        <div class="col-xs-8 col-sm-9">

            <div class="addevent form-group">
                <h4>Activitate:</h4>
                <input type="text" class="form-control" placeholder="Numele activitatii" id="numeactivitate">
            </div>
            <div class="addevent form-group">
                <h4>Ora de inceput:</h4>
                <select name="orain" class="form-control" id="orain">
                    <option value="57">8</option>
                    <option value="123.5">9</option>
                    <option value="190">10</option>
                    <option value="256.5">11</option>
                    <option value="323">12</option>
                    <option value="389.5">13</option>
                    <option value="456">14</option>
                    <option value="522.5">15</option>
                    <option value="589">16</option>
                    <option value="655.5">17</option>
                    <option value="722">18</option>
                    <option value="788.5">19</option>
                </select>
            </div>
            <div class="addevent form-group">
                <h4>Ora de sfarsit:</h4>
                <select name="orasf" class="form-control" id="orasf">
                    <option value="123.5">9</option>
                    <option value="190">10</option>
                    <option value="256.5">11</option>
                    <option value="323">12</option>
                    <option value="389.5">13</option>
                    <option value="456">14</option>
                    <option value="522.5">15</option>
                    <option value="589">16</option>
                    <option value="655.5">17</option>
                    <option value="722">18</option>
                    <option value="788.5">19</option>
                    <option value="855">20</option>
                </select>
            </div>
            <div class="addevent form-group">
                <h4>Culoare:</h4>
                <select name="culoare" class="form-control" id="culoare">
                    <option value="red">Rosu</option>
                    <option value="green">Verde</option>
                    <option value="yellow">Galben</option>
                    <option value="blue">Albastru</option>
                    <option value="brown">Maro</option>
                </select>
            </div>
            <div class="addevent form-group">
                <h4>-</h4>
                <input class="form-control btn btn-primary" type="button" value="Adauga eveniment" onclick="canvasaddevent()"><br class="specialbr"><br class="specialbr">
                <a class="form-control btn btn-primary" id="download">Descarca orarul</a>
            </div>

        </div>
    </div>
<br>
    <div style="text-align:center;">
<img src="images/emptyorar.png" style="display:none;" onload="drawim()" id="emptyorar">
    <canvas id="smartorar" style="width:90%" width="870px" height="533px">Your browser does not support the.php5 canvas tag.</canvas></div>
</section>
<script>
document.getElementById('download').addEventListener('click', function() {
    downloadCanvas(this, 'smartorar', 'orar.png');
}, false);
</script>
</div>

    <footer class="well" style="background-color:black;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</div>
</body>

</html>
