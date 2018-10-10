<!DOCTYPE html>
<html>

<head><title>Adaugare orar</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <?php
        $userrole=getUserRole($_SESSION['user']);
        if ($auth && $userrole==1) :
        ?>
        <form action="phpscripts/updateorar.php" onsubmit="return updateOrar()" method="post" enctype="multipart/form-data"><!--onsubmit="return validator()"-->
            <div class="input-group">
                <label for="facultate">Facultate:</label>
                <?php
                include_once 'phplib/facilities.php';

                selectFac();
                ?>
            </div>
            <div class="input-group" id="specDiv" style="display:none">
                <label for="specializare">Specializare:</label>
            </div><br id="brspec" style="display:none">
            <div class="input-group" id="groupDiv" style="display:none">
                <label for="grupa">Grupa:</label>
            </div><br id="brgrup" style="display:none">
            <h5 id="validatorgrupa" style="color:red;display:none">Nu ati selectat grupa</h5>
            <div class="input-group">
                <label for="poza">Imagine orar(necompletat==>orar gol):</label><br>
                <input type="file" name="poza" class="form-control" id="poza"><br>
                <h5 id="validatorpoza" style="color:red;display:none">Nu ati selectat poza</h5>
            </div><br>
            <input type="submit" class="btn btn-primary" value="Adauga">
        </form>
        <?php
        else : echo 'Nu aveti drepturi';
        endif
        ?>
    </section>

    <footer class="well" style="background-color:black;color:white">
        <h4>Created by Sorin Marica</h4>
    </footer>

</body>

</html>