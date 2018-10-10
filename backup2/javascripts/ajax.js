
  function createUser()
  {
		var user=document.getElementsByName("user")[0];
		var pass=document.getElementsByName("pass")[0];
		var mail=document.getElementsByName("mail")[0];
		var p=document.getElementById("ajaxanswer");
		p.innerHTML = '<img src="../images/load.gif" style="width:10%">';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var a=xhttp.responseText;
				p.innerHTML=a;
				if (a.localeCompare("Te-ai inregistrat cu succes")==0)
					window.location.replace("index.php");
			}
		};
		xhttp.open("POST", "phpscripts/createaccount.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("user="+user.value+"&pass="+pass.value+"&mail="+mail.value);
  }
  
  function conectUser()
  {
		var user=document.getElementsByName("user")[0];
		var pass=document.getElementsByName("pass")[0];
		var p=document.getElementById("ajaxanswer");
		p.innerHTML = '<img src="../images/load.gif" style="width:10%">';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var a=xhttp.responseText;
				p.innerHTML=a;
				if (a.localeCompare("Te-ai conectat cu succes")==0)
					window.location.replace("index.php");
			}
		};
		xhttp.open("POST", "phpscripts/conectare.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("user="+user.value+"&pass="+pass.value);
  }
  
  function publishArticle()
  {
		var titlu=document.getElementsByName("titlu")[0];
		var continut=document.getElementsByName("continut")[0];
		var p=document.getElementById("ajaxanswer");
		p.innerHTML = '<img src="../images/load.gif" style="width:10%">';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var a=xhttp.responseText;
				p.innerHTML=a;
			}
		};
		xhttp.open("POST", "phpscripts/submitarticle.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("titlu="+titlu.value+"&continut="+continut.value);
  }
  
  function updateArticle()
  {
	    var id=document.getElementById("id");
		var titlu=document.getElementsByName("titlu")[0];
		var continut=document.getElementsByName("continut")[0];
      	var p=document.getElementById("ajaxanswer");
      	p.innerHTML = '<img src="../images/load.gif" style="width:10%">';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var a=xhttp.responseText;
				p.innerHTML=a;
			}
		};
		xhttp.open("POST", "phpscripts/updatearticle.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("id="+id.value+"&titlu="+titlu.value+"&continut="+continut.value);
  }

  function changeMail()
  {
      var mailnou=document.getElementById("mailnou");
      var confirm=document.getElementById("confirm");
      var mailvechi=document.getElementById("mailvechi");
      var p=document.getElementById("ajaxanswer");
      if (mailnou.value.localeCompare(confirm.value)==0)
	  {
          p.innerHTML = '<img src="../images/load.gif" style="width:10%">';
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if (xhttp.readyState == 4 && xhttp.status == 200) {
                  var a=xhttp.responseText;
                  p.innerHTML=a;
              }
          };
          xhttp.open("POST", "phpscripts/changemail.php", true);
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhttp.send("mailnou="+mailnou.value+"&confirm="+confirm.value+"&mailvechi="+mailvechi.value);
	  }
	  else
		  p.innerHTML="Adresele de mail nu coincid";
  }

  function lostPass()
  {
      var mail=document.getElementById("mail");
      var p=document.getElementById("ajaxanswer");
	  p.innerHTML = '<img src="../images/load.gif" style="width:10%">';
	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		  if (xhttp.readyState == 4 && xhttp.status == 200) {
			  var a=xhttp.responseText;
			  p.innerHTML=a;
		  }
	  };
	  xhttp.open("POST", "phpscripts/lostpassword.php", true);
	  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhttp.send("mail="+mail.value);
  }

  function changePass()
  {
      var pv=document.getElementById("parolaveche");
      var pn=document.getElementById("parolanoua");
      var confirmare=document.getElementById("confirmare");
      var p=document.getElementById("ajaxanswer");
      p.innerHTML = '<img src="../images/load.gif" style="width:10%">';
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
              var a=xhttp.responseText;
              p.innerHTML=a;
          }
      };
      xhttp.open("POST", "phpscripts/changepass.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("parolaveche="+pv.value+"&parolanoua="+pn.value+"&confirmare="+confirmare.value);
  }

