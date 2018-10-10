<?php

	include_once 'connectdb.php';
	include_once 'usersactions.php';

    function ModExist($mod)
    {
        if (empty($mod))
            return false;

        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM moderatori WHERE moderator_id=?");
        $sql->bind_param("i",$mod);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            return false;
        }
        $sql->bind_result($nr);
        $sql->fetch();
        $sql->close();

        $conn->close();

        if ($nr==0)
            return false;
        return true;
    }

	function createmod($username,$articol,$qa,$chestionare)
    {
        if (empty($username))
            die ("Lipseste userul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($articol) || ($articol !=-1 && $articol !=1))
            die ("Lipseste valoarea lui articol <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($qa) || ($qa !=-1 && $qa !=1))
            die ("Lipseste valoarea lui qa <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($chestionare) || ($chestionare !=-1 && $chestionare !=1))
            die ("Lipseste valoarea lui chestionare <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn = connect();

        include_once "usersactions.php";

        $roles=checkModerator($username);
        if ($roles[0]==-1 && $roles[1]==-1 && $roles[2]==-1)
        {
            $uid = getUserId($username);
            if ($uid == -1)
            {
                $conn->close();
                die("Utilizatorul nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
            $sql = $conn->prepare("INSERT INTO moderatori (user_id,articole,qa,chestionare) VALUES (?,?,?,?)");
            $sql->bind_param("iiii",$uid,$articol,$qa,$chestionare);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error admin.php createmod 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }

            $sql->close();
            $conn->close();
            return true;
        }
        else
        {
            $uid = getUserId($username);
            if ($uid == -1)
            {
                $conn->close();
                die("Utilizatorul nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }
            $sql = $conn->prepare("UPDATE moderatori SET articole=?,qa=?,chestionare=? WHERE user_id=?");
            $sql->bind_param("iiii",$articol,$qa,$chestionare,$uid);
            if (!$sql->execute())
            {
                $sql->close();
                $conn->close();
                die("Query error admin.php createmod 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
                return false;
            }

            $sql->close();
            $conn->close();
            return true;
        }
	}
	
	function deletemod($modid)
	{
        if (empty($modid))
            die ("Lipseste moderatorul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!ModExist($modid))
            die ("Moderatorul nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
		$conn=connect();
		
		$sql=$conn->prepare("DELETE FROM moderatori WHERE moderator_id=?");
		$sql->bind_param("i",$modid);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error admin.php deleteMod 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		
		$sql->close();
		$conn->close();
		return true;
	}

	function selectmod()
	{
		$conn=connect();
		
		$sql=$conn->prepare("SELECT m.moderator_id,u.username FROM moderatori m,utilizatori u WHERE u.user_id=m.user_id");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error admin.php selectmod 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
		$sql->bind_result($modid,$username);
		echo '<select name="moderator" id="moderator" class="form-control">';
		while ($sql->fetch())
			echo '<option value="'.htmlspecialchars($modid).'">'.htmlspecialchars($username).'</option>';
		echo '</select>';
		
		$sql->close();
		$conn->close();
	}

	function updateOrar($grupa,$path)
    {
        include_once 'facilities.php';
        if (empty($path))
            die ("Lipseste imaginea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($grupa))
            die ("Lipseste grupa <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!GroupExist($grupa))
            die ("Grupa nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

        $conn=connect();

        $sql=$conn->prepare("SELECT image FROM grupa WHERE id=?");
        $sql->bind_param("i",$grupa);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error admin.php updateorar 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($img);
        $sql->fetch();
        unlink($img);
        $sql->free_result();

        $sql=$conn->prepare("UPDATE grupa SET image=? WHERE id=?");
        $sql->bind_param("si",$path,$grupa);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error admin.php updateorar 2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

?>