<!DOCTYPE html>
<html>

<head><title>Adaugare grupa</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script src="javascripts/validators.js"></script>
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

    <section id="questions" class="topcontent well">
        <?php
        $userrole=getUserRole($_SESSION['user']);
        if ($auth && $userrole==1) :
            ?>
            <form action="phpscripts/insertGroup.php" method="post" onsubmit="return addgroup()" enctype="multipart/form-data">
                <div class="input-group"></div><label for="facultate">Facultate:</label><?php include_once 'phplib/facilities.php'; selectFac2(); ?>
                <div class="input-group" id="specDiv" style="display:none">
                    <label for="specializare">Specializare:</label>
                </div>
                <h5 id="validatorspec" style="color:red;display:none">Nu ati ales specializarea</h5>
                <div class="input-group"><label for="grupa">Nume grupa:</label><input id="grupa" name="grupa" type="text" class="form-control"></div>
                <h5 id="validatorgrupa" style="color:red;display:none">Nu ati introdus numele grupei</h5>
                <div class="input-group"><label for="serie">Serie:</label><input id="serie" name="serie" type="text" class="form-control"></div>
                <h5 id="validatorserie" style="color:red;display:none">Nu ati adaugat seria</h5>
                <div class="input-group"><label for="an">An:</label><input id="an" name="an" type="text" class="form-control"></div>
                <h5 id="validatoran" style="color:red;display:none">Nu ati adaugat anul</h5>
                <div class="input-group"><label for="poza">Orar:</label><input type="file" name="poza" class="form-control" id="poza"></div><br>
                <input type="submit" class="btn btn-primary" value="Creeaza"></form>
            <?php
        else : echo 'Nu aveti drepturi';
        endif
        ?>
    </section>

    <footer class="well" style="background-color:black;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</div>
</body>

</html>