<?php
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 4/6/2017
 * Time: 5:48 PM
 */

    include_once 'connectdb.php';

    function SpecExist($spec)
    {
        if (empty($spec))
            return false;

        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM specializare WHERE id=?");
        $sql->bind_param("i",$spec);
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

    function FacExists($fac)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM facultate WHERE nume=?");
        $sql->bind_param("s",$fac);
        if (!$sql->execute()) {
            $sql->close();
            $conn->close();
            return false;
        }
        $sql->bind_result($nr);
        $sql->fetch();
        if ($nr>0)
        {
            $sql->close();
            $conn->close();
            return true;
        }

        $sql->close();
        $conn->close();
        return false;
    }

    function FacExistsId($fac)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM facultate WHERE id=?");
        $sql->bind_param("s",$fac);
        if (!$sql->execute()) {
            $sql->close();
            $conn->close();
            return false;
        }
        $sql->bind_result($nr);
        $sql->fetch();
        if ($nr>0)
        {
            $sql->close();
            $conn->close();
            return true;
        }

        $sql->close();
        $conn->close();
        return false;
    }

    function GroupExist($grupa)
    {
        if (empty($grupa))
            return false;

        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM grupa WHERE id=?");
        $sql->bind_param("i",$grupa);
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

    function insertGroup($grupa,$serie,$an,$specializare,$poza)
    {
        if (empty($grupa))
            die ("Numele grupei lipseste <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($serie))
            die ("Lipseste seria <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($an))
            die ("Lipseste anul <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($poza))
            die ("Lipseste poza <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($specializare))
            die ("Lipseste specializarea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!SpecExist($specializare))
            die ("Specializarea nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

        $conn=connect();

        $sql=$conn->prepare("INSERT INTO grupa (nume,serie,an,specializare,image) VALUES (?,?,?,?,?)");
        $sql->bind_param("sssis",$grupa,$serie,$an,$specializare,$poza);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php insertgroup 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();

        return true;
    }

    function insertFacultate($nume)
    {
        if (empty($nume))
            die ("Numele facultatii lipseste <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (FacExists($nume))
            return false;

        $conn=connect();

        $sql=$conn->prepare("INSERT INTO `facultate` (nume) VALUES (?)");
        $sql->bind_param("s",$nume);
        if (!$sql->execute()) {
            $sql->close();
            $conn->close();
            die("Eroare query facilities.php insertfacultate 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();

        return true;
    }

    function insertSpec($nume,$fac)
    {
        if (empty($nume))
            die ("Numele specializarii lipseste <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (empty($fac))
            die ("Lipseste facultatea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        if (!FacExistsId($fac))
            die ("Facultatea nu exista <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");

        $conn=connect();

        $sql=$conn->prepare("INSERT INTO `specializare` (nume,id_facultate) VALUES (?,?)");
        $sql->bind_param("si",$nume,$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php insertSpec <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();

        return true;
    }

    function selectSpec($fac,$spec=-1)
    {
        if (empty($fac))
            die ("Lipseste facultatea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("SELECT id,nume FROM specializare WHERE id_facultate=?");
        $sql->bind_param("i",$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php selectSpec <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($id,$nume);
        echo '<select name="specializare" id="specializare" class="form-control" onchange="changeGroups()">';
        echo '<option disabled selected value>    </option>';

        while ($sql->fetch())
            if (numberOfGroups($id)>0)
                if ($id==$spec) echo '<option value="'.htmlspecialchars($id).'" SELECTED>'.htmlspecialchars($nume).'</option>';
                    else echo '<option value="'.htmlspecialchars($id).'">'.htmlspecialchars($nume).'</option>';
        echo '</select>';

        $sql->close();
        $conn->close();
    }

    function selectSpec2($fac,$spec=-1)
    {
        if (empty($fac))
            die ("Lipseste facultatea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("SELECT id,nume FROM specializare WHERE id_facultate=?");
        $sql->bind_param("i",$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php selectspec2 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($id,$nume);
        echo '<select name="specializare" id="specializare" class="form-control" onchange="changeGroups()">';
        echo '<option disabled selected value>    </option>';

        while ($sql->fetch())
            if ($id==$spec) echo '<option value="'.htmlspecialchars($id).'" SELECTED>'.htmlspecialchars($nume).'</option>';
                else echo '<option value="'.htmlspecialchars($id).'">'.htmlspecialchars($nume).'</option>';
        echo '</select>';

        $sql->close();
        $conn->close();
    }

    function selectFac($fac=-1)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT id,nume FROM facultate");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php selectFac <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($id,$nume);
        echo '<select name="facultate" id="facultate" class="form-control" onchange="changeSpec()">';
        echo '<option disabled selected value>    </option>';
        while ($sql->fetch())
                if (numberOfSpecs($id)>0)
                    if ($fac==$id) echo '<option value="' . htmlspecialchars($id) . '" SELECTED>' . htmlspecialchars($nume) . '</option>';
                        else echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($nume) . '</option>';
        echo '</select>';

        $sql->close();
        $conn->close();
    }

    function selectFac2($fac=-1)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT id,nume FROM facultate");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php selectFac2 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($id,$nume);
        echo '<select name="facultate" id="facultate" class="form-control" onchange="changeSpec2()">';
        echo '<option disabled selected value>    </option>';
        while ($sql->fetch())
            if (numberOfSpecs2($id)>0)
                if ($fac==$id) echo '<option value="' . htmlspecialchars($id) . '" SELECTED>' . htmlspecialchars($nume) . '</option>';
                    else echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($nume) . '</option>';
        echo '</select>';

        $sql->close();
        $conn->close();
    }

    function selectFac3($fac=-1)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT id,nume FROM facultate");
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php selectFac3 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($id,$nume);
        echo '<select name="facultate" id="facultate" class="form-control" onchange="changeSpec2()">';
        echo '<option disabled selected value>    </option>';
        while ($sql->fetch())
            if ($fac==$id) echo '<option value="' . htmlspecialchars($id) . '" SELECTED>' . htmlspecialchars($nume) . '</option>';
            else echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($nume) . '</option>';
        echo '</select>';

        $sql->close();
        $conn->close();
    }

    function selectGroups($spec,$grupa=-1)
    {
        $conn=connect();

        $sql=$conn->prepare("SELECT id,nume FROM grupa WHERE specializare=?");
        $sql->bind_param("i",$spec);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php selectGroups 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($id,$nume);
        echo '<select name="grupa" id="grupa" class="form-control" onchange="changeorar(this)">';
        echo '<option disabled selected value>    </option>';
        while ($sql->fetch())
            if ($id==$grupa) echo '<option value="'.htmlspecialchars($id).'" SELECTED>'.htmlspecialchars($nume).'</option>';
                else echo '<option value="'.htmlspecialchars($id).'">'.htmlspecialchars($nume).'</option>';
        echo '</select>';

        $sql->close();
        $conn->close();
    }

    function deleteFac($fac)
    {
        if (empty($fac))
            die ("Lipseste facultatea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("DELETE FROM grupa WHERE specializare in (SELECT id FROM specializare WHERE id_facultate=?)");
        $sql->bind_param("s",$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php deleteFac 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM specializare WHERE id_facultate=?");
        $sql->bind_param("s",$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error2 facilities.php deleteFac 2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM facultate WHERE id=?");
        $sql->bind_param("s",$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php deleteFac 3 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

    function deleteSpec($spec)
    {
        if (empty($spec))
            die ("Lipseste specializarea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("DELETE FROM grupa WHERE specializare=?");
        $sql->bind_param("s",$spec);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php deleteSpec 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql=$conn->prepare("DELETE FROM specializare WHERE id=?");
        $sql->bind_param("s",$spec);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php deleteSpec 2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

    function deleteGrupa($grup)
    {
        if (empty($grup))
            die ("Lipseste grupa <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

		$sql=$conn->prepare("SELECT image FROM grupa WHERE id=?");
		$sql->bind_param("s",$grup);
		if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php deleteGrupa 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($img);
        $sql->fetch();
        if (strcmp($img,'../images/emptyorar.png')!=0)
			unlink($img);
        $sql->free_result();

        $sql=$conn->prepare("DELETE FROM grupa WHERE id=?");
        $sql->bind_param("s",$grup);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php deleteGrupa 2 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }

        $sql->close();
        $conn->close();
        return true;
    }

    function numberOfSpecs($fac)
    {
        if (empty($fac))
            die ("Lipseste facultatea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("SELECT id FROM specializare s WHERE s.id_facultate=?");
        $sql->bind_param("i",$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php numberofspecs 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($id);
        $nr=0;
        while ($sql->fetch())
            if (numberOfGroups($id)>0) $nr++;

        $sql->close();
        $conn->close();
        return $nr;
    }

    function numberOfSpecs2($fac)
    {
        if (empty($fac))
            die ("Lipseste facultatea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("SELECT count(id) FROM specializare s WHERE s.id_facultate=?");
        $sql->bind_param("i",$fac);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php numberOfSpecs2 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($nr);
        $sql->fetch();

        $sql->close();
        $conn->close();
        return $nr;
    }

    function numberOfGroups($spec)
    {
        if (empty($spec))
            die ("Lipseste specializarea <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("SELECT count(*) FROM grupa WHERE specializare=?");
        $sql->bind_param("i",$spec);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php numberOfGroups 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($nr);
        $sql->fetch();

        $sql->close();
        $conn->close();
        return $nr;
    }

    function getOrar($grupa)
    {
        if (empty($grupa))
            die ("Lipseste grupa <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
        $conn=connect();

        $sql=$conn->prepare("SELECT image FROM grupa WHERE id=?");
        $sql->bind_param("i",$grupa);
        if (!$sql->execute())
        {
            $sql->close();
            $conn->close();
            die("Query error facilities.php getOrar 1 <button class=\"btn btn-default\" onclick=\"history.go(-1);\">Inapoi </button>");
            return false;
        }
        $sql->bind_result($path);
        $sql->fetch();

        $sql->close();
        $conn->close();
        return $path;
    }
