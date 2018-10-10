<!DOCTYPE html>
<html>

<head><title>Unealta studentului - Profil</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Marica Sorin">
    <meta name="title" content="Unealta studentului">
    <meta name="description" content="O unealta pentru studentul de pretutindeni">
    <meta http-equiv="Content-Type" content="text.php; charset=utf-8" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="styles/bs/css/bootstrap.min.css">
    <script src="styles/jquery.min.js"></script>
    <script src="styles/bs/js/bootstrap.min.js"></script>
    <script src="javascripts/facilities.js"></script>
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
        <a href="#" onclick="resetDetails()">Sterge detaliile actuale</a><br>
        <a href="changepass.php">Schimba parola contului</a><br>
        <a href="changemail.php">Schimba adresa de mail</a><br><br>
        <form action="phpscripts/updatedetails.php" method="post" onsubmit="return validator()" enctype="multipart/form-data">
            <div class="input-group">
                <label for="poza">Poza(necompletata==>ramane la fel):</label><br>
                <?php
                echo '<h3 style="text-align:center"><img style="height:100px" src="';
    getUserphoto($_SESSION['user']);
    echo '" alt="'.htmlspecialchars($_SESSION['user']).'"></h3>';
                ?>
                <input type="file" name="poza" class="form-control" id="poza"><br>
            </div><br>
            <?php
                $grupa=getGrupa($_SESSION['user']);

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
            <div class="input-group">
                <label for="github">Link github:</label>
                <input type="text" name="github" id="github" placeholder="Ex: https://github.com/SorinGabriel" <?php if (strcmp(getGit($_SESSION['user']),'N/A')!=0) echo 'value="'.htmlspecialchars(getGit($_SESSION['user'])).'"'; ?> class="form-control"><span id="validgithub" style="display:none;color:red">Linkul trebuie sa fie al unui profil de github</span>
            </div><br>
            <div class="input-group">
                <label for="detalii">Detalii:</label><br>
                <textarea id="detalii" class="form-control" name="detalii" rows="4" cols="50"><?php if (strcmp(getDetalii($_SESSION['user']),"N/A")!=0) echo htmlspecialchars(getDetalii($_SESSION['user'])); else echo ''; ?></textarea>
            </div><br>
            <div class="checkbox">
                <label><input type="checkbox" name="publicmail" value="Yes" <?php if (getPublic($_SESSION['user'])==1) echo 'CHECKED'; ?>>Doresc ca mail-ul sa fie afisat public</label>
            </div><br>
            <input type="submit" class="btn btn-primary" value="Modifica">
        </form>
    </section>

    <footer class="well" style="background-color:black;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</body>

</html>
