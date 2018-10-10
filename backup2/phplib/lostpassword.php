<?php
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/8/2017
 * Time: 1:11 AM
 */

    include_once 'connectdb.php';

    function checkLostPassRequest($user)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT data,id FROM cereriparola WHERE user=?");
        $sql->bind_param("s",$user);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($data,$id);
        $sql->fetch();


        $cdata=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
        $t1=strtotime($cdata);
        $t2=strtotime($data);
        $seconds_diff=$t1-$t2;

        if ($seconds_diff>(3600*24))
        {
            $sql->free_result();
            $sql=$conn->prepare("DELETE FROM cereriparola WHERE id=?");
            $sql->bind_param("i",$id);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
        }
        else
        {
            $sql->close();
            $conn->close();
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

    function checkKey($key)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT user FROM cereriparola WHERE keylink=?");
        $sql->bind_param("s",$key);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($user);
        $sql->fetch();

        $sql->close();
        $conn->close();
        return $user;
    }

    function destroyLinkLp($key)
    {
        $conn=connect();

        $sql=$conn->prepare("DELETE FROM cereriparola WHERE keylink=?");
        $sql->bind_param("s",$key);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

    function changePass2($key,$user,$pass)
    {
        if (strlen($pass)<6)
            die("Parola trebuie sa aiba minim 6 caractere");
        if (checkKey($key)==$user)
        {
            $conn=connect();

            $pass=md5($pass);

            $sql=$conn->prepare("UPDATE utilizatori SET password=? WHERE user_id=?");
            $sql->bind_param("si",$pass,$user);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }

            $sql->close();
            $conn->close();
            return destroyLinkLp($key);
        }
        else
            return false;
    }

    function changePassRequest($mail)
    {
        require_once 'mail.php';
        include_once 'usersactions.php';

        $user=getUserIdByMail($mail);

        if (checkLostPassRequest($user))
        {
            $conn=connect();

            $data=gmdate("Y-m-d H:i:s",time() + 3600*(2+date("I")));
            $key=md5(uniqid(rand(), true));

            $subiect="Recuperare parola";
            $mesaj='S-a primit o solicitare de schimbare de schimbare a parolei contului tau, '.htmlspecialchars(getUsername($user)).' de pe StudentHelper.<br><br>
                Pentru a schimba parola accesati linkul <a href="http://localhost/lpchange.php?key='.htmlspecialchars($key).'">Acesta</a><br><br>
                Daca nu dumneavoastra ati solicitat schimbarea atunci accesati linkul <a href="http://localhost/deletelp.php?key='.htmlspecialchars($key).'">Acesta</a> pentru a putea face o solicitare noua<br><br>';

            $aux=mailsender($mail,$subiect,$mesaj,getUsername($user));

            if ($aux)
            {
                $sql=$conn->prepare("INSERT INTO cereriparola (keylink,user,data) VALUES (?,?,?)");
                $sql->bind_param("sis",$key,$user,$data);
                if (!$sql->execute())
                {
                    $sql->close();
                    $conn->close();
                    die("Query error1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                    return false;
                }

                $sql->close();
                $conn->close();
                return true;
            }
            else
            {
                $conn->close();
                return false;
            }
        }
    }
