
	function clearField(input,val) {
		  if(input.value == val)
			 input.value="";
	};
	
	function fillField(input,val) {
		if(input.value == "")
			input.value=val;
	};

function changeform(x)
{
	var y=document.getElementById("active");
	y.style.display="none";
	var z=document.getElementsByClassName(x.value);
	z[0].style.display="block";
	y.id="";
	z[0].id="active";
}

var submittw=0;
var submitasd=0;
var submitpoo=0;
var submitlfa=0;

function evalexam(x)
{
	if (x.name=="poo3") 
	{
		submitpoo=1;
	}
	else if (x.name=="lfa3")
	{
		submitlfa=1;
	}
	else if (x.name=="asd3")
	{
		submitasd=1;
	}
	else if (x.name=="tw3")
	{
		submittw=1;
	}
	var nrc=0,nrchecked=0;
	var j=x.name.substr(x.name.length-1,x.name.length-1)-1;
	var num=x.name.substr(0,x.name.length-1);
	for (var i=1;i<=j;i++)
	{
		var a=document.getElementsByName(num+i);
		var b=document.getElementsByClassName(num+i);
		for (var k=0;k<a.length;k++)	
		{
			if (a[k].checked)
			{
				if (a[k].value.match("corect")) 
				{
					nrc++;
					b[k].style.backgroundColor="green";
				}
				else
				{
					b[k].style.backgroundColor="red";
				}
				nrchecked++;
			}
		}
	}
	if (nrchecked==0) 
	{
		alert("Timpul s-a scurs");
	}
	else
	{
		alert("Ai raspuns corect la "+nrc+" din 2 intrebari");
	}
}

var cpoo=1;
var casd=1;
var ctw=1;
var clfa=1;

function startcount(x)
{
	alert("Pregateste-te!Testul tau va incepe in 3 secunde dupa ce apesi ok.");
	setTimeout(function(){
	if ((x.name=="poo3" && cpoo==1) || (x.name=="asd3" && casd==1) || (x.name=="lfa3" && clfa==1) || (x.name=="tw3" && ctw==1))
	{
		if (x.name=="poo3") 
		{
			cpoo=0;
		}
		else if (x.name=="lfa3")
		{
			clfa=0;
		}
		else if (x.name=="asd3")
		{
			casd=0;
		}
		else if (x.name=="tw3")
		{
			ctw=0;
		}
		var xid=document.getElementById(x.name);
		xid.style.display="block";
		var timer=document.getElementById("timer".concat(x.name)).innerHTML;
		if (timer>0)
		{
			var interval=setInterval(function(){
				timer=document.getElementById("timer".concat(x.name)).innerHTML;
				document.getElementById("timer".concat(x.name)).innerHTML=timer-1;
				if (timer==1 || ((submittw==1 && x.name=="tw3") || (submitasd==1 && x.name=="asd3") || (submitlfa==1 && x.name=="lfa3") || (submitpoo==1 && x.name=="poo3")))
				{
					clearInterval(interval);
					if (timer==1) 
					{
						evalexam(x);
					}
				}
			},1000);
		}
	}
	},3000);
}

function changeorar(x)
{
	var grupa=document.getElementById("grupa").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var a=xhttp.responseText;
            var img=document.getElementById("orar");
            img.src=a;
        }
    };
    xhttp.open("POST", "phpscripts/getOrar.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("grupa="+grupa);
}

    function canvasaddevent()
    {
        var top=document.getElementsByName("zi");
        var i;
        var nr=0;
        for (i=0;i<top.length;i++)
        {
            if (top[i].checked)
            {
                nr++;
                var left=document.getElementById("orain").value;
                if (parseInt(left)<parseInt(document.getElementById("orasf").value))
                {
                    var lungimeorizontala=parseInt(document.getElementById("orasf").value)-parseInt(left);
                    var toppos=top[i].value;
                    var color=document.getElementById("culoare").value;
                    var lungimeverticala=90;
                    var descris=document.getElementById("numeactivitate").value;
                    if (descris.localeCompare("")==0)
                        alert("Nu ati scris numele activitatii");
                    else {
                        var c = document.getElementById("smartorar");
                        var ctx = c.getContext("2d");
                        ctx.beginPath();
                        ctx.rect(left, toppos, lungimeorizontala, lungimeverticala);
                        ctx.fillStyle = color.toString();
                        if (ctx.measureText(descris).width>lungimeorizontala)
                            alert("Textul este prea lung");
                        else
                        {
                            ctx.fill();
                            ctx.font = "1em Verdana";
                            ctx.fillStyle="black";
                            ctx.fillText(descris,left,parseInt(toppos)+parseInt(15));
                        }
                    }

                }
                else
                    alert("Ora de sfarsit trebuie sa fie mai mare decat cea de inceput");
            }
        }
        if (nr==0) alert("Nu ati selectat zilele");
    }


function drawim()
{
	var c = document.getElementById("smartorar");
	var ctx = c.getContext("2d");
	var img=document.getElementById("emptyorar");
	ctx.drawImage(img,0,0,870,533);
}

function blush(event)
{
	var elem=document.getElementsByTagName("h1");
	elem[0].style.transition="all 2s";
	elem[0].style.color="Red";
	setTimeout(function()
	{
		elem[0].style.color="Black";
	},2000);
}

function downloadCanvas(link, canvasId, filename)
{
	link.href = document.getElementById(canvasId).toDataURL();
    link.download = filename;
}

function resetDetails()
{
	if (confirm("Sigur doriti sa va resetati datele contului?"))
		window.location.replace("phpscripts/removedetails.php");
}
