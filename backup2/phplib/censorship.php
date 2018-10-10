<?php

class censorship
{
	private $dictionary;
	
	function __construct()
	{
		$f=file_get_contents("../phplib/bannedwords.txt");
		$this->dictionary=explode(PHP_EOL,$f);
		array_pop($this->dictionary);
		$this->dictionary=array_map('rtrim',$this->dictionary);
	}

	function aprove($word)
	{
		if (array_search(strtolower($word),$this->dictionary)!==false)
			return false;
		return true;
	}
}
