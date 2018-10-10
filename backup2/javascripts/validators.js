/**
 * Created by Sorin on 4/8/2017.
 */

    function updateOrar()
    {
        var x=document.getElementById("grupa");
        console.log(x);
        if (x==null)
        {
            document.getElementById("validatorgrupa").style.display="block";
            return false;
        }
        document.getElementById("validatorgrupa").style.display="none";

        var x=document.getElementById("grupa").value;
        console.log(x);
        if (!x)
        {
            document.getElementById("validatorgrupa").style.display="block";
            return false;
        }
        document.getElementById("validatorgrupa").style.display="none";

        return true;
    }

    function createFac()
    {
        var x=document.getElementById("facultate").value;
        if (!x)
        {
            document.getElementById("validatorfac").style.display="block";
            return false;
        }
        document.getElementById("validatorfac").style.display="none";
        return true;
    }

    function addSpec()
    {
        var x=document.getElementById("facultate").value;
        if (!x)
        {
            document.getElementById("validatorfac").style.display="block";
            return false;
        }
        document.getElementById("validatorfac").style.display="none";
        return true;
    }

    function addgroup()
    {
        var x=document.getElementById("specializare");
        if (!x)
        {
            document.getElementById("validatorspec").style.display="block";
            return false;
        }
        document.getElementById("validatorspec").style.display="none";

        var x=document.getElementById("specializare").value;
        if (!x)
        {
            document.getElementById("validatorspec").style.display="block";
            return false;
        }
        document.getElementById("validatorspec").style.display="none";

        var x=document.getElementById("grupa").value;
        if (!x)
        {
            document.getElementById("validatorgrupa").style.display="block";
            return false;
        }
        document.getElementById("validatorgrupa").style.display="none";

        var x=document.getElementById("serie").value;
        if (!x)
        {
            document.getElementById("validatorserie").style.display="block";
            return false;
        }
        document.getElementById("validatorserie").style.display="none";
        var x=document.getElementById("an").value;
        if (!x)
        {
            document.getElementById("validatoran").style.display="block";
            return false;
        }
        document.getElementById("validatoran").style.display="none";

        return true;
    }

    function deleteSpec() {
        var x = document.getElementById("specializare");
        if (!x) {
            document.getElementById("validatorspec").style.display = "block";
            return false;
        }
        document.getElementById("validatorspec").style.display = "none";

        var x = document.getElementById("specializare").value;
        if (!x) {
            document.getElementById("validatorspec").style.display = "block";
            return false;
        }
        document.getElementById("validatorspec").style.display = "none";

        return true;
    }

    function deletegroup() {
        var x = document.getElementById("grupa");
        if (!x) {
            document.getElementById("validatorgrupa").style.display = "block";
            return false;
        }
        document.getElementById("validatorgrupa").style.display = "none";

        var x = document.getElementById("grupa").value;
        if (!x) {
            document.getElementById("validatorgrupa").style.display = "block";
            return false;
        }
        document.getElementById("validatorgrupa").style.display = "none";

        return true;
    }

    function createmod()
    {
        var x = document.getElementById("username").value;
        if (!x) {
            document.getElementById("validatorusername").style.display = "block";
            return false;
        }
        document.getElementById("validatorusername").style.display = "none";

        var x = document.getElementById("articole").checked;
        var y = document.getElementById("chestionare").checked;
        var z = document.getElementById("qa").checked;
        if (!x && !y && !z) {
            document.getElementById("validatormod").style.display = "block";
            return false;
        }
        document.getElementById("validatormod").style.display = "none";

        return true;
    }