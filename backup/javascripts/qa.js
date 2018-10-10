
  function postanswer()
  {
	var x=document.getElementById("postmesage").value;
	var y=document.getElementById("grup").value;
	var z=document.getElementById("confirm");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if (xhttp.responseText.localeCompare("Raspunsul a fost adaugat")==0)
                window.location.reload(false);
            else
				z.innerHTML=xhttp.responseText;
		}
	};
	xhttp.open("POST", "phpscripts/answer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("comentariu="+x+"&grup="+y);
  }
  
  function deleteqa(id)
  {
	if (confirm("Sigur doriti sa stergeti?"))
	{
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				if (xhttp.responseText.localeCompare("Succes")==0)
				{
                    window.location.replace("/");
                }
				else
					alert(xhttp.responseText);
			}
		};
		xhttp.open("POST", "phpscripts/deleteqa.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("id="+id); 		
	}
  }
  
  function modifica(x)
  {
		var y=x.parentNode;
		if (confirm("Sigur doriti sa modificati?"))
		{
            var brs=y.getElementsByClassName("br");
			var elements=y.getElementsByClassName("input-group");
			var titlu=y.getElementsByClassName("titlu")[0];
            var id=y.getElementsByClassName("id")[0];
			var content=y.getElementsByClassName("continut")[0];
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					if (xhttp.responseText.localeCompare("Succes")==0) {
                        var z = y.childNodes;
                        for (var i = 0; i < z.length; i++) {
                            try {
                                if (z[i].style.display == "none")
                                    z[i].style.display = "block";
                            }
                            catch (e) {
                                y.removeChild(z[i]);
                            }
                        }
                        z[1].innerHTML = titlu.value;
                        z[2].innerHTML = content.value;
                        y.removeChild(x);
                        while (elements.length>0)
							y.removeChild(elements[0]);
                        while (brs.length>0)
                            y.removeChild(brs[0]);
					}
					else
						alert(xhttp.responseText);
				}
			};
			xhttp.open("POST", "phpscripts/updateqa.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("id="+id.value+"&titlu="+titlu.value+"&content="+content.value); 		
		}  
  }
  
  function change(x)
  {
	  var y=x.parentNode;
	  var z=y.childNodes;
	  for (var i=0;i<z.length;i++)
		  z[i].style.display="none";
	  var parentDiv=document.createElement("div");
	  parentDiv.className="input-group";
	  var titlu=document.createElement("input");
	  titlu.type="text";
	  titlu.id="titlul";
	  titlu.className="titlu form-control";
	  titlu.value=z[1].innerHTML;
	  var t1=document.createElement("label");
	  t1.for="titlul";
	  var text1=document.createTextNode("Titlu:");
	  t1.appendChild(text1);
	  parentDiv.appendChild(t1);
	  parentDiv.appendChild(titlu);
	  y.appendChild(parentDiv);
	  var br=document.createElement("br");
	  br.className="br";
	  y.appendChild(br);
	  var parentDiv2=document.createElement("div");
	  parentDiv2.className="input-group";
	  var t2=document.createElement("label");
	  t2.for="continutul";
	  var text2=document.createTextNode("Continut:");
	  t2.appendChild(text2);
	  parentDiv2.appendChild(t2);
	  var continut=document.createElement("textarea");
	  continut.className="continut form-control";
	  continut.value=z[2].innerHTML;
	  continut.id="continutul";
	  parentDiv2.appendChild(continut);
	  y.appendChild(parentDiv2);
	  var buton=document.createElement("input");
	  buton.type="button";
	  buton.value="Modifica";
	  buton.className="btn btn-primary";
	  buton.onclick=function(){modifica(this)};
	  var br2=document.createElement("br");
	  br2.className="br";
	  y.appendChild(br2);
	  y.appendChild(buton);
  }
  
  function rate(x,y)
  {
		var y=document.getElementsByName(y)[0];
		y=y.options[y.selectedIndex].value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				if (xhttp.responseText.localeCompare("Succes")==0)
				{
					location.reload();
				}
			}
		};
		xhttp.open("POST", "phpscripts/rateqa.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("aid="+x+"&rate="+y);
  }
