<?php

class cosinesim
{
	private $words,$counts1,$counts2,$array1,$array2,$similarity;
	function __construct($v1,$v2)
	{
		$this->array1=$v1;
		$this->array2=$v2;
		$aux=explode(" ",$v1);
		$aux2=explode(" ",$v2);
		$this->words=array();
		$this->counts1=array();
		$this->counts2=array();
		for ($i=0;$i<count($aux);$i++)
		{
			$aux3=array_search($aux[$i],$this->words);
			//echo $aux[$i].' '.$aux3.'<br>';
			if ($aux3 !== false)
				$this->counts1[$aux3]++;
			else
			{
				array_push($this->words,$aux[$i]);
				array_push($this->counts1,1);
				array_push($this->counts2,0);
			}
		}
		for ($i=0;$i<count($aux2);$i++)
		{
			$aux3=array_search($aux2[$i],$this->words);
			//echo $aux2[$i].' '.$aux3.'<br>';
			if ($aux3 !== false)
				$this->counts2[$aux3]++;
			else
			{
				array_push($this->words,$aux2[$i]);
				array_push($this->counts1,0);
				array_push($this->counts2,1);
			}
		}
		$this->similarity=$this->vectorProduct()/($this->norm($this->counts1)*$this->norm($this->counts2));
	}
	
	function getSimilarity()
	{
		return $this->similarity;
	}
	
	function vectorProduct()
	{
		$sum=0;
		for ($i=0;$i<count($this->words);$i++)
			$sum+=$this->counts1[$i]*$this->counts2[$i];
		return $sum;
	}
	
	function norm($v)
	{
		$sum=0;
		for ($i=0;$i<count($v);$i++)
			$sum+=$v[$i]*$v[$i];
		return sqrt($sum);
	}
	
	function showVectors()
	{
		for ($i=0;$i<count($this->words);$i++)
			echo $this->words[$i].' '.$this->counts1[$i].' '.$this->counts2[$i].'<br>';
		echo 'Similaritate:' . $this->similarity;
	}

}
