<?php

interface graf
{
    function __construct($i);
    function actualizare();
    function afisare();
    function getDim();
}

class grafUsers implements graf
{
    private $matrix;
    private $dim;
    private $line;
    function __construct($i)
    {
        $this->line=$i;
        $this->dim=$this->getDim()+1;
        $this->matrix=array_fill(0,$this->dim,array_fill(0,$this->dim,0));
    }
    function actualizare()
    {
        for ($j = 0; $j < $this->dim; $j++)
            $this->matrix[$this->line][$j]=(15/100)*$this->ratingSimilarity($this->line,$j)+(40/100)*$this->chestionareSimiliarity($this->line,$j)+(45/100)*$this->answerQASimiliarity($this->line,$j);
    }
    function afisare()
    {
        for ($j = 0; $j < $this->dim; $j++)
            echo $this->matrix[$this->line][$j].'|||';
    }
    function getDim()
    {
        include_once 'connectdb.php';

        $conn=connect();

        $sql=$conn->prepare("SELECT max(user_id) FROM utilizatori");
        $sql->execute();
        $sql->bind_result($mid);
        $sql->fetch();

        return $mid;
    }
    function ratingSimilarity($id1,$id2)
    {
        $v1=getGivenMeanRatingsChest($id1);
        $v2=getRecievedMeanRatingsChest($id1);
        $v3=getGivenMeanRatingsQA($id1);
        $v4=getRecievedMeanRatingsQA($id1);
        $w1=getGivenMeanRatingsChest($id2);
        $w2=getRecievedMeanRatingsChest($id2);
        $w3=getGivenMeanRatingsQA($id2);
        $w4=getRecievedMeanRatingsQA($id2);

        $dif1=abs($v1-$w1);
        $dif2=abs($v2-$w2);
        $dif3=abs($v3-$w3);
        $dif4=abs($v4-$w4);

        $totalval=((5-$dif1)+(5-$dif2)+(5-$dif3)+(5-$dif4))/20;
        return $totalval;
    }
    function chestionareSimiliarity($id1,$id2)
    {
        $v1=getChestionareRezolvate($id1);
        $v2=getRezultateChestionare($id1);
        $w1=getChestionareRezolvate($id2);
        $w2=getRezultateChestionare($id2);

        $matches=0;
        for ($i=0;$i<count($v1);$i++)
            for ($j=0;$j<count($w1);$j++)
                if ($v1[$i]==$w1[$j]) $matches++;
        if (max(count($v1),count($w1))==0)
            return 1;
        else
            $matchesrezult=$matches/(max(count($v1),count($w1)));

        $similarityfactor=array();
        for ($i=0;$i<count($v2);$i++)
            for ($j=0;$j<count($w2);$j++)
                if ($v2[$i][0]==$w2[$j][0]) array_push($similarityfactor,abs($v2[$i][1]-$w2[$j][1])/$v2[$i][2]);

        $sf=0;
        for ($i=0;$i<count($similarityfactor);$i++)
            $sf=$sf+(1-$similarityfactor[$i]*$similarityfactor[$i])/count($similarityfactor);
        $finalrezult=$matchesrezult/2+$sf/2;

        return $finalrezult;
    }
    function answerQASimiliarity($id1,$id2)
    {
        $v1=getAnswerdQuestions($id1);
        $w1=getAnswerdQuestions($id2);

        $matches=0;
        for ($i=0;$i<count($v1);$i++)
            for ($j=0;$j<count($w1);$j++)
                if ($v1[$i]==$w1[$j]) $matches++;
        if (max(count($v1),count($w1))==0)
            $matchesrezult=1;
        else
            $matchesrezult=$matches/(max(count($v1),count($w1)));

        return $matchesrezult;
    }
}

class grafChestionare implements graf
{
    private $matrix;
    private $dim;
    private $user;
    private $line;
    function __construct($i)
    {
        $this->line=$i;
        $this->user=0;
        $this->dim=$this->getDim()+1;
        $this->matrix=array_fill(0,$this->dim,array_fill(0,$this->dim,0));
    }
    function actualizare()
    {
            for ($j = 0; $j < $this->dim; $j++)
            {
                if (getCategoryChest($this->line) == getCategoryChest($j))
                    $x = 20 / 100;
                else
                    $x = 0;
                $this->matrix[$this->line][$j] = $x+5/100*$this->userSimilarity($this->line,$j)+30/100*$this->ratingSimilarity($this->line,$j)+10/100*$this->ratingUserSimilarity($this->line,$j)+35/100*$this->resultsSimilarity($this->line,$j);
            }
    }
    function afisare()
    {
            for ($j = 0; $j < $this->dim; $j++)
                echo $this->matrix[$this->line][$j].'|||';
    }
    function setUser($user)
    {
        $this->user=$user;
    }
    function getDim()
    {
        include_once 'connectdb.php';

        $conn=connect();

        $sql=$conn->prepare("SELECT max(id) FROM chestionare");
        $sql->execute();
        $sql->bind_result($maxid);
        $sql->fetch();

        return $maxid;
    }
    function userSimilarity($id1,$id2)
    {
        $v1=getUsersWhoSolved($id1);
        $w1=getUsersWhoSolved($id2);

        $matches=0;
        for ($i=0;$i<count($v1);$i++)
            for ($j=0;$j<count($w1);$j++)
                if ($v1[$i]==$w1[$j]) $matches++;
        if (max(count($v1),count($w1))==0)
            $matchesrezult=1;
        else
            $matchesrezult=$matches/(max(count($v1),count($w1)));

        return $matchesrezult;
    }
    function ratingSimilarity($id1,$id2)
    {
        $v1=getRatingChest($id1);
        $w1=getRatingChest($id2);

        return (5-abs($v1-$w1))/5;
    }
    function ratingUserSimilarity($id1,$id2)
    {
        $id1=getUserChest($id1);
        $id2=getUserChest($id2);
        $v1=getGivenMeanRatingsChest($id1);
        $v2=getRecievedMeanRatingsChest($id1);
        $v3=getGivenMeanRatingsQA($id1);
        $v4=getRecievedMeanRatingsQA($id1);
        $w1=getGivenMeanRatingsChest($id2);
        $w2=getRecievedMeanRatingsChest($id2);
        $w3=getGivenMeanRatingsQA($id2);
        $w4=getRecievedMeanRatingsQA($id2);

        $dif1=abs($v1-$w1);
        $dif2=abs($v2-$w2);
        $dif3=abs($v3-$w3);
        $dif4=abs($v4-$w4);

        $totalval=((5-$dif1)+(5-$dif2)+(5-$dif3)+(5-$dif4))/20;
        return $totalval;
    }
    function resultsSimilarity($id1,$id2)
    {
        $v1=getChestResults($id1);
        $w1=getChestResults($id2);
        $x1=getUserResults($this->user,$id1);

        $rezultat=(5-abs($v1-$w1))/5;
        $rezultat2=(5-abs($w1-$x1))/5;

        return $rezultat/2+$rezultat2/2;
    }
}

class grafQA implements graf
{
    private $matrix;
    private $dim;
    private $line;
    private $user;
    function __construct($i)
    {
        $this->line=$i;
        $this->dim=$this->getDim();
        $this->matrix=array_fill(0,$this->dim,array_fill(0,$this->dim,0));
    }
    function actualizare()
    {
        for ($j = 0; $j < $this->dim; $j++)
        {
            if (getQAcat($this->line) == getQAcat($j))
                $x = 1;
            else
                $x = 0;
            $this->matrix[$this->line][$j] = /*(25/100)*$x+(25/100)*$this->ratingSimilarity($this->line,$j)+(25/100)*$this->ratingUserSimilarity($this->line,$j);+*/(25/100)*$this->usersSimilarity($this->line,$j);
        }
    }
    function afisaresim()
    {
        $values=array();
        $posibilitati=array();
        for ($j = 0; $j < $this->dim; $j++)
        {
            if ($this->matrix[$this->line][$j] > 0.75)
                array_push($posibilitati, $j);
            array_push($values,array($j,$this->matrix[$this->line][$j]));
        }
        usort($values,"cmp");
        //continue coding here
    }
    function setUser($user)
    {
        $this->user=$user;
    }
    function afisare()
    {
        for ($j = 0; $j < $this->dim; $j++)
            echo $this->matrix[$this->line][$j].'|||';
    }
    function getDim()
    {
        include_once 'connectdb.php';

        $conn=connect();

        $sql=$conn->prepare("SELECT max(grup) FROM qapost");
        $sql->execute();
        $sql->bind_result($mid);
        $sql->fetch();

        return $mid;
    }
    function ratingSimilarity($id1,$id2)
    {
        include_once 'rating.php';

        $v1=getRateQa(getQaId($id1));
        $w1=getRateQa(getQaId($id2));

        $dif1=5-abs($v1[0]-$w1[0]);
        $dif2=1+abs($v1[1]-$w1[1]);

        return ($dif1/$dif2)/5;
    }
    function ratingUserSimilarity($id1,$id2)
    {
        $id1=getUserQa($id1);
        $id2=getUserQa($id2);
        $v1=getGivenMeanRatingsChest($id1);
        $v2=getRecievedMeanRatingsChest($id1);
        $v3=getGivenMeanRatingsQA($id1);
        $v4=getRecievedMeanRatingsQA($id1);
        $w1=getGivenMeanRatingsChest($id2);
        $w2=getRecievedMeanRatingsChest($id2);
        $w3=getGivenMeanRatingsQA($id2);
        $w4=getRecievedMeanRatingsQA($id2);

        $dif1=abs($v1-$w1);
        $dif2=abs($v2-$w2);
        $dif3=abs($v3-$w3);
        $dif4=abs($v4-$w4);

        $totalval=((5-$dif1)+(5-$dif2)+(5-$dif3)+(5-$dif4))/20;
        return $totalval;
    }
    function usersSimilarity($id1,$id2)
    {
        $v1=getAnswersQa($id1);
        $w1=getAnswersQa($id2);

        $matches=0;
        for ($i=0;$i<count($v1);$i++)
            for ($j=0;$j<count($w1);$j++)
                if ($v1[$i]==$w1[$j]) $matches++;
        if (max(count($v1),count($w1))==0)
            $matchesrezult=1;
        else
            $matchesrezult=$matches/(max(count($v1),count($w1)));

        return $matchesrezult;
    }
}

function cmp($x,$y)
{
    if ($x[1]==$y[1])
        return 0;
    return ($x[1] < $y[1]) ? -1 : 1;
}

function getQaId($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT id FROM qapost WHERE grup=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getAnswersQa($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT user FROM qapost WHERE grup=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $frezultat=array();
    while ($sql->fetch())
        array_push($frezultat,$rezultat);

    return $frezultat;
}

function getUserQa($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT user FROM qapost WHERE grup=? LIMIT 0,1");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getQAcat($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT categorie FROM qapost WHERE grup=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getChestResults($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT avg(corecte/total) FROM rezultate WHERE id_chestionar=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getUserResults($id,$id_chest)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT corecte/total FROM rezultate WHERE id_user=? and id_chestionar=?");
    $sql->bind_param("ii",$id,$id_chest);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getUserChest($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT user_id FROM chestionare WHERE id=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getRatingChest($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT avg(nota) FROM ratingchestionare WHERE chestionar_id=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getCategoryChest($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT id_cat FROM chestionare WHERE id=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}

function getUsersWhoSolved($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $frezultat=array();
    $sql=$conn->prepare("SELECT id_user FROM rezultate WHERE id_chestionar=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    while ($sql->fetch())
        array_push($frezultat,$rezultat);

    return $frezultat;
}

function getAnswerdQuestions($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $frezultat=array();
    $sql=$conn->prepare("SELECT grup FROM qapost WHERE user=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    while ($sql->fetch())
        array_push($frezultat,$rezultat);

    return $frezultat;
}

function getChestionareRezolvate($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $frezultat=array();
    $sql=$conn->prepare("SELECT id_chestionar FROM rezultate WHERE id_user=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    while ($sql->fetch())
        array_push($frezultat,$rezultat);

    return $frezultat;
}

function getRezultateChestionare($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $frezultat=array();
    $sql=$conn->prepare("SELECT id_chestionar,corecte,total FROM rezultate WHERE id_user=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat,$corecte,$total);
    while ($sql->fetch())
        array_push($frezultat,array($rezultat,$corecte,$total));

    return $frezultat;
}

function getRecievedMeanRatingsQA($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT avg(nota) FROM ratingqa WHERE qa_id IN (SELECT id FROM qapost WHERE user=?)");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}
function getGivenMeanRatingsQA($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT avg(nota) FROM ratingqa WHERE user_id=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}
function getRecievedMeanRatingsChest($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT avg(nota) FROM ratingchestionare WHERE chestionar_id IN (SELECT id FROM chestionare WHERE user_id=?)");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}
function getGivenMeanRatingsChest($id)
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT avg(nota) FROM ratingchestionare WHERE user_id=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $sql->bind_result($rezultat);
    $sql->fetch();

    return $rezultat;
}
