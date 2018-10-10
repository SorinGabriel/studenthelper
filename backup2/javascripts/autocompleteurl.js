
	function autocomp()
	{
		var x=document.getElementById("ncat").value;
		var y=x;
		while (y.indexOf(" ")!=-1)
			y=y.replace(" ","-");
		var z=document.getElementById("url");
		z.value=y;
	}