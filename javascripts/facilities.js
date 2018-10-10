/**
 * Created by Sorin on 4/6/2017.
 */

    function changeSpec()
    {
        var x=document.getElementById("specDiv");
        if (x!=null)
        {
            var facultate=document.getElementById("facultate");
            var grupa=document.getElementById("groupDiv");
            if (grupa!=null)
                grupa.style.display="none";
            var aux=document.getElementById("aux");
            if (aux!=null)
            {
                aux.parentElement.removeChild(aux);
            }

            var y = document.createElement("span");
            y.id = "aux";

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    y.innerHTML = xhttp.responseText;
                    x.appendChild(y);
                    x.style.display="block";
                    var br=document.getElementById("brspec");
                    br.style.display="block";
                }
            };
            xhttp.open("POST", "phpscripts/getSelectSpec.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("facultate=" + facultate.value);
        }
    }

    function changeGroups()
    {
        var x=document.getElementById("groupDiv");
        if (x!=null)
        {
            var specializare=document.getElementById("specializare");
            var aux=document.getElementById("aux2");
            if (aux!=null)
            {
                aux.parentElement.removeChild(aux);
            }

            var y = document.createElement("span");
            y.id = "aux2";

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    y.innerHTML = xhttp.responseText;
                    x.appendChild(y);
                    x.style.display="block";
                    var br=document.getElementById("brgrup");
                    br.style.display="block";
                }
            };
            xhttp.open("POST", "phpscripts/getSelectGroups.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("specializare=" + specializare.value);
        }
    }

    function changeSpec2()
    {
        var x=document.getElementById("specDiv");
        if (x!=null)
        {
            var facultate=document.getElementById("facultate");
            var grupa=document.getElementById("groupDiv");
            if (grupa!=null)
                grupa.style.display="none";
            var aux=document.getElementById("aux");
            if (aux!=null)
            {
                aux.parentElement.removeChild(aux);
            }

            var y = document.createElement("span");
            y.id = "aux";

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    y.innerHTML = xhttp.responseText;
                    x.appendChild(y);
                    x.style.display="block";
                    var br=document.getElementById("brspec");
                    br.style.display="block";
                }
            };
            xhttp.open("POST", "phpscripts/getSelectSpec2.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("facultate=" + facultate.value);
        }
    }

    function validator()
    {
        var x=document.getElementById("github");
        if (x.value.localeCompare("")!=0 && (x.value.indexOf("http://github.com")<0 && x.value.indexOf("https://github.com")<0)) {
            document.getElementById("validgithub").style.display = "block";
            return false;
        }
        if (x.value.substr(x.value.length-4).localeCompare("com/")==0 || x.value.substr(x.value.length-3).localeCompare("com")==0)
        {
            document.getElementById("validgithub").style.display = "block";
            return false;
        }
    }