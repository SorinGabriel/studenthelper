<?php

/* Documentatie:

Sisteme cu filtrare colaborativa -  unui utilizator i se recomanda itemi pe baza voturilor tuturor userilor din trecut.

1. Neighborhood-based Collaborative Filtering
O submultime de useri e selectata in functie de similitudinea cu userul activ
 O combinatie calculata a voturilor lor e folosita pentru a face preziceri pentru acest user

Algoritm (complet in ppt):

1. Se asigneaza o greutate/valoare tuturor userilor in legatura cu asemanarea cu userul activ.
wa,u- asemanarea dintre userul u si userul activ a	Pearson correlation coefficient
i - itemul votat
ru,i  – votul userului u pentru itemul i
ru  – media voturilor userului u
2. Se selecteaza k useri care au cea mai mare asemanare cu userul activ – neighborhood.
3. Se calculeaza o predictie folosind combinatia de voturi din neighborhood.
pa,i - predictia pentru userul activ a pentru itemul i
K – neighborhood
*/

class nbcfqa
{
    private $users,$w,$r,$dimw,$dimr,$k,$predictions,$p;
    function __construct($k)
    {
        /*1. Neighborhood-based Collaborative Filtering*/
        $this->k=$k;
        $this->predictions=array();
        $this->users=getUsers();
        $this->dimw=getMaxUid()+1;
        $this->dimr=getMaxItems()+1;
        $this->w=array_fill(0,$this->dimw,array_fill(0,$this->dimw,0));
        $this->r=array_fill(0,$this->dimw,array_fill(0,$this->dimr,0));
        $this->p=array_fill(0,$this->dimw,array_fill(0,$this->dimr,0));
        $arra=getRatings();
        for ($i=0;$i<count($arra);$i++)
            $this->r[$arra[$i][0]][$arra[$i][1]]=$arra[$i][2];

        for ($i=0;$i<$this->dimw;$i++)
            for ($j=0;$j<$this->dimw;$j++)
            {
                $avg=$this->averageR($i);
                $avg2=$this->averageR($j);
                $sum=0;
                for ($k=0;$k<$this->dimr;$k++)
                    $sum += ($this->r[$i][$k] - $avg) * ($this->r[$j][$k] - $avg2);
                $sum2=0;
                for ($k=0;$k<$this->dimr;$k++)
                    $sum2+=($this->r[$i][$k]-$avg)*($this->r[$i][$k]-$avg);
                $sum3=0;
                for ($k=0;$k<$this->dimr;$k++)
                    $sum3+=($this->r[$j][$k]-$avg2)*($this->r[$j][$k]-$avg2);
                $numitor=sqrt($sum2*$sum3);
                if ($numitor==0 || $i==$j)
                    $this->w[$i][$j]=0;
                else
                    $this->w[$i][$j]=$sum/$numitor;
            }
    }
    function afisare()
    {
        echo 'W:<br>';
        for ($i = 0; $i < $this->dimw; $i++)
        {
            for ($j = 0; $j < $this->dimw; $j++)
                echo $this->w[$i][$j] . ' ';
            echo '<br>';
        }
        echo '<br>R:<br>';
        for ($i = 0; $i < $this->dimw; $i++)
        {
            for ($j = 0; $j < $this->dimr; $j++)
                echo $this->r[$i][$j] . ' ';
            echo '<br>';
        }
        echo '<br>P:<br>';
        for ($i = 0; $i < $this->dimw; $i++)
        {
            for ($j = 0; $j < $this->dimr; $j++)
                echo $this->p[$i][$j] . ' ';
            echo '<br>';
        }
        echo '<br>Predictii:<br>';
        for ($i=0;$i<count($this->predictions);$i++)
            echo $this->predictions[$i][0].' '.$this->predictions[$i][1].' '.$this->predictions[$i][2].'<br>';
    }
    function getKNeighbors($user)
    {
        $finalrezult=array();
        $neighbors=array();
        for ($i=0;$i<$this->dimw;$i++)
            if ($i!=$user) array_push($neighbors,array($i,$this->w[$user][$i]));

        usort($neighbors,"cmp");
        for ($i=0;$i<$this->k;$i++)
            array_push($finalrezult, $neighbors[$i][0]);
        return $finalrezult;
    }
    function setPredictions($user)
    {
        $kn=$this->getKNeighbors($user);
        for ($i = 0; $i < $this->dimr; $i++)
            if ($this->r[$user][$i]==0) {
                $avg = $this->averageR($user);
                $sum = 0;
                for ($j = 0; $j < count($kn); $j++)
                    $sum += $this->r[$kn[$j]][$i] * $this->w[$user][$kn[$j]];
                $sum2 = 0;
                for ($j = 0; $j < count($kn); $j++)
                    $sum2 += $this->w[$user][$kn[$j]];
                if ($sum2==0)
                    $this->p[$user][$i]=0;
                else
                    $this->p[$user][$i] = $avg + $sum / $sum2;
                array_push($this->predictions,array($user,$i,$this->p[$user][$i]));
            }
    }
    function getPredictions($user,$nr)
    {
        include_once 'qa.php';
        include_once 'usersactions.php';
        $k=0;
        usort($this->predictions,"cmp2");
        for ($i=0;$i<count($this->predictions) && $k<$nr;$i++)
            if ($this->predictions[$i][0]==$user && $this->predictions[$i][2]>0 && !checkIfTaken($this->predictions[$i][1],getUsername($user)))
            {
                if ($k==0) echo '<h4>Te-ar putea interesa:<h4><ul class="nav nav-pills">';
                $k++;
                echo '<li><a href="raspunsuri.php?grup='.htmlspecialchars($this->predictions[$i][1]).'">'.htmlspecialchars(getQaTitle($this->predictions[$i][1])).'</a></li>';
            }
        echo '</ul></h4>';
    }
    function averageR($ind)
    {
        $sum=0;
        $nr=0;
        for ($i=0;$i<$this->dimr;$i++)
            if ($this->r[$ind][$i]!=0)
            {
                $sum += $this->r[$ind][$i];
                $nr = 0;
            }

        if ($nr==0) return 0;
        else return $sum/$nr;
    }
}

function cmp($a, $b)
{
    if ($a[1] == $b[1]) {
        return 0;
    }
    return ($a[1] < $b[1]) ? 1 : -1;
}

function cmp2($a, $b)
{
    if ($a[2] == $b[2]) {
        return 0;
    }
    return ($a[2] < $b[2]) ? 1 : -1;
}

function getMaxItems()
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT max(grup) FROM qapost");
    if (!$sql->execute())
    {
        $sql->close();
        $conn->close();
        die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        return false;
    }
    $sql->bind_result($id);
    $sql->fetch();

    return $id;
}

function getRatings()
{
    include_once 'connectdb.php';

    $conn=connect();

    $rez=array();
    $sql=$conn->prepare("SELECT user_id,grup,nota FROM ratingqa rqa,qapost qp WHERE rqa.qa_id=qp.id and qp.date = (SELECT min(date) FROM qapost WHERE grup=qp.grup)");
    if (!$sql->execute())
    {
        $sql->close();
        $conn->close();
        die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        return false;
    }
    $sql->bind_result($uid,$gid,$nota);
    while ($sql->fetch())
        array_push($rez,array($uid,$gid,$nota));

    return $rez;
}

function getMaxUid()
{
    include_once 'connectdb.php';

    $conn=connect();

    $sql=$conn->prepare("SELECT max(user_id) FROM utilizatori");
    if (!$sql->execute())
    {
        $sql->close();
        $conn->close();
        die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        return false;
    }
    $sql->bind_result($uid);
    $sql->fetch();

    return $uid;
}

function getUsers()
{
    include_once 'connectdb.php';

    $conn=connect();

    $rez=array();
    $sql=$conn->prepare("SELECT user_id FROM utilizatori");
    if (!$sql->execute())
    {
        $sql->close();
        $conn->close();
        die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        return false;
    }
    $sql->bind_result($uid);
    while ($sql->fetch())
        array_push($rez,$uid);

    return $rez;
}
