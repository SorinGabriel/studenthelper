
	function addquestion()
	{
		var intrebari=document.getElementById("intrebari");
		/*<div class="intrebare">
<label for="intrebare1">Intrebare:</label><input type="text" name="intrebare1" id="intrebare1"><br>
<input type="radio" name="raspunsi1"><input type="text" name="rasp1i1" id="rasp1i1"><br>
<input type="radio" name="raspunsi1"><input type="text" name="rasp2i1" id="rasp2i1"><br>
<input type="radio" name="raspunsi1"><input type="text" name="rasp3i1" id="rasp3i1"><br>
<input type="radio" name="raspunsi1"><input type="text" name="rasp4i1" id="rasp4i1"><br>
</div>*/

		var number=intrebari.getElementsByClassName("intrebare").length+1;
		var div=document.createElement("div");
		div.className="intrebare";
		div.id="intrebare"+number;
		var label=document.createElement("label");
		label.htmlFor="intrebare"+number; 
		label.innerHTML="Intrebare:";
		var input1=document.createElement("input");
		input1.type="text";
		input1.name="intrebare"+number;
		input1.className="form-control";
		input1.placeholder="Intrebare";
		input1.id="intrebare"+number;
		var br1=document.createElement("br");
		var br6=document.createElement("br");
		var br7=document.createElement("br");
		var input2=document.createElement("input");
		input2.type="radio";
		input2.name="raspunsi"+number;
		input2.value="1";
		var input3=document.createElement("input");
		input3.type="text";
		input3.name="rasp1i"+number;
		input3.placeholder="Raspuns 1";
		input3.id="rasp1i"+number;
		var br2=document.createElement("br");
		var input4=document.createElement("input");
		input4.type="radio";
		input4.name="raspunsi"+number;
		input4.value="2";
		var input5=document.createElement("input");
		input5.type="text";
		input5.name="rasp2i"+number;
		input5.placeholder="Raspuns 2";
		input5.id="rasp2i"+number;
		var br3=document.createElement("br");
		var input6=document.createElement("input");
		input6.type="radio";
		input6.name="raspunsi"+number;
		input6.value="3";
		var input7=document.createElement("input");
		input7.type="text";
		input7.name="rasp3i"+number;
		input7.placeholder="Raspuns 3";
		input7.id="rasp3i"+number;
		var br4=document.createElement("br");
		var input8=document.createElement("input");
		input8.type="radio";
		input8.name="raspunsi"+number;
		input8.value="4";
		var input9=document.createElement("input");
		input9.type="text";
		input9.name="rasp4i"+number;
		input9.placeholder="Raspuns 4";
		input9.id="rasp4i"+number;
		var br5=document.createElement("br");
		div.appendChild(label);
		div.appendChild(input1);
		div.appendChild(br1);
		div.appendChild(br6);
		div.appendChild(br7);
		var row=document.createElement("div");
		row.className="row";
		var col=document.createElement("div");
		col.className="col-xs-8 col-sm-11";
        col.appendChild(input2);
        col.appendChild(input3);
        col.appendChild(br2);
        col.appendChild(input4);
        col.appendChild(input5);
        col.appendChild(br3);
        col.appendChild(input6);
        col.appendChild(input7);
        col.appendChild(br4);
        col.appendChild(input8);
        col.appendChild(input9);
        col.appendChild(br5);
		row.appendChild(col);
		var div2=document.createElement("div");
		div2.className="col-xs-4 col-sm-1";
		var bt2=document.createElement("input");
		bt2.type="button";
		bt2.value="X";
		bt2.className="btn btn-danger";
		bt2.addEventListener("click",function(){remquestion(number);});
		div2.appendChild(bt2);
		row.appendChild(div2);
		div.appendChild(row);
		var brx=document.createElement("br");
		var buton=document.getElementById("adaugaintrebare");
		div.appendChild(brx);
		intrebari.insertBefore(div,buton);
		//intrebari.insertBefore(brx,buton);
		var nrintrebari=document.getElementById("numarintrebari");
		nrintrebari.value=parseInt(nrintrebari.value)+1;
	}

	function remquestion(x)
	{
		var y=document.getElementById("intrebare"+x);
		y.parentElement.removeChild(y);
        var nrintrebari=document.getElementById("numarintrebari");
        nrintrebari.value=parseInt(nrintrebari.value)-1;
	}

	var time;
	
	function takequiz()
	{
		if (confirm("Esti pregatit?In momentul in care apasati ok va incepe si cronometrul sa scada"))
		{
			var startbut=document.getElementById("startbut");
			startbut.style.display="none";
			var questions=document.getElementsByClassName("intrebare");
			for (var i=0;i<questions.length;i++)
				questions[i].style.display="block";
			var buton=document.getElementById("finish");
			buton.style.display="block";
			var redzone=document.getElementById("time").innerHTML/10+1;
			time=setInterval(function(){
			var timer=document.getElementById("time").innerHTML;
			document.getElementById("time").innerHTML=timer-1;
			if (timer<=redzone)
				document.getElementById("time").style.color="Red";
			if (timer==1)
			{
				evaluareexamen();
			}
			},1000);
		}
	}
	
	function evaluareexamen()
	{
		var buton=document.getElementById("finish");
		buton.style.display="none";
		clearInterval(time);
		var id=document.getElementById("idul");
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var a=JSON.parse(xhttp.responseText);
				showresult(a);
			}
		};
		xhttp.open("POST", "phpscripts/evalchestionar.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("id="+id.value);
	}
	
	function showresult(x)
	{
		var intrebari=document.getElementsByClassName("intrebare");
		var gresite=0;
		for (var i=0;i<intrebari.length;i++)
		{
			var div=intrebari[i].getElementsByClassName(x[i])[0];
			div.style.backgroundColor="green";
			var rval=0;
			var string="raspunsi"+(i+1);
			var radioval=document.getElementsByName(string);
			for (var j=0;j<radioval.length;j++)
				if (radioval[j].checked)
					rval=radioval[j].value;
			if (rval!=x[i])
			{
				gresite++;
				if (rval>=1 && rval<=4)
				{
					var div2=intrebari[i].getElementsByClassName(rval)[0];
					div2.style.backgroundColor="red";
				}
			}
		}
		var rezultate=document.getElementById("rezultate");
		var corecte=intrebari.length-gresite;
		var procent=(corecte/(intrebari.length))*100;
		rezultate.innerHTML="Rezultat:"+procent.toFixed(2)+"%<br>Ai raspuns la:"+corecte+"/"+intrebari.length+" intrebari";
		var conexion=document.getElementById("connection");
		if (conexion.value=="c")
		{
			var id=document.getElementById("idul");
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					var a=xhttp.responseText;
					var y=document.getElementById("ratethisquiz");
					y.style.display="block";
				}
			};
			xhttp.open("POST", "phpscripts/registerresults.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("corecte="+corecte+"&total="+intrebari.length+"&idchestionar="+id.value);
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
		xhttp.open("POST", "phpscripts/ratechestionar.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("cid="+x+"&rate="+y);
  }
  
  function deletechestionar(x)
  {
      if (confirm("Sigur doriti sa stergeti?")) {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function () {
              if (xhttp.readyState == 4 && xhttp.status == 200) {
                  if (xhttp.responseText.localeCompare("Succes") == 0) {
                      window.location.replace("/");
                  }
              }
          };
          xhttp.open("POST", "phpscripts/deletechestionar.php", true);
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhttp.send("cid=" + x);
	  }
  }
  
  function validate()
  {
	  var titlu=document.getElementById("titlu");
	  if (!titlu.value || titlu.value==="")
	  {
		  alert("Trebuie completat titlul");
		  return false;
	  }
	  var descriere=document.getElementById("descriere");
	  if (!descriere.value || descriere.value==="")
	  {
		  alert("Trebuie completata descrierea");
		  return false;
	  }
	  var timp=document.getElementById("timp");
	  if (!timp.value || timp.value==="")
	  {
		  alert("Trebuie completat timpul");
		  return false;
	  }
	  var inputs=document.getElementById("formpreg").getElementsByTagName("input");
	  for (var u=0;u<inputs.length;u++)
		  if (!inputs[u].value || inputs[u].value==="")
		  {
			  alert("Trebuie completate toate campurile");
			    return false;
		  }
	  var j=1;
	  var i=document.getElementsByName('raspunsi'+j);
	  var u=parseInt(document.getElementById("numarintrebari").value);
	  console.log("u="+u);
	  while (u>0)
	  {
		  var ok=true;
		  for (var k=0;k<4;k++)
			  if (i[k].checked)
				  ok=false;
		  if (ok)
		  {
			  alert("Trebuie sa selectati varianta corecta");
			  return false;
		  }
		  u--;
		  console.log("u="+u);
		  console.log("j="+j);
		  j++;
          i = document.getElementsByName('raspunsi' + j);
		  while (i.length!=4 && u>0) {
            	console.log("j="+j);
		  		j++;
              	i = document.getElementsByName('raspunsi' + j);
          }
	  }
  }