
  function postcomment(articol)
  {
	var x=document.getElementById("comment");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var a=document.getElementById("succesmessage");
			if (xhttp.responseText.localeCompare("Comentariul a fost adaugat")==0)
				location.reload();
			else
				a.innerHTML=xhttp.responseText;
		}
	};
	xhttp.open("POST", "phpscripts/postcomment.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("comentariu="+x.value+"&articol="+articol);
  }
  
  function deletecom(id)
  {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if (xhttp.responseText.localeCompare("Succes")==0)
				location.reload();
			else
				alert(xhttp.responseText);
		}
	};
	xhttp.open("POST", "phpscripts/deletecom.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("id="+id);
  }
  
  function deletearticle()
  {
	  if (confirm("Sunteti sigur ca doriti sa stergeti acest articol?"))
	  {
			var x=document.getElementById("idarticol");
			var y=document.getElementById("user");
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					if (xhttp.responseText.localeCompare("Succes")==0)
					{
						window.location.replace("/");
					}
					else
					{
						alert(xhttp.responseText);
					}
				}
			};
			xhttp.open("POST", "phpscripts/deletearticle.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("aid="+x.value+"&uname="+y.value);	  
	  }  
  }
  
  function rate(x)
  {
		var y=document.getElementById("rate");
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
		xhttp.open("POST", "phpscripts/ratearticole.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("aid="+x+"&rate="+y);
  }
