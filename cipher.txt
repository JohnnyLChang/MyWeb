<?php
function pad($message,$block_size)
{
	return str_pad($message, max(floor( (strlen($message)-1)/$block_size)+1,1)*$block_size);
}
function sbox($block,$round=0,$reverse=false)
{
	static $sbox=null;
	if ($sbox===null) //generate sbox
	{
		srand(SEED);
		$sbox=array_fill(0, ROUNDS, array_fill(0,256,0));
		for ($k=0;$k<ROUNDS;++$k)
		{

			$base=range(0,255);
			for ($i=0;$i<256;++$i)
			{
				$r=rand(0,count($base)-1);
				$index=array_keys($base)[$r];
				$sbox[$k][$i]=$base[$index];
				unset($base[$index]);
			}
		}
	}

	$out=str_repeat(" ", BLOCK_SIZE);
	if ($reverse)
		for ($i=0;$i<BLOCK_SIZE;++$i)
			$out[$i]=chr(array_search(ord($block[$i]), $sbox[$round]));
	else
		for ($i=0;$i<BLOCK_SIZE;++$i)
			$out[$i]=chr($sbox[$round][ord($block[$i])]);
	return $out;
}
function pbox($block,$round=0,$reverse=false)
{
	srand(SEED);
	static $pbox=null;
	if ($pbox===null) //generate pbox
	{
		srand(SEED);
		$pbox=array_fill(0, ROUNDS, array_fill(0,BLOCK_SIZE,0));
		for ($k=0;$k<ROUNDS;++$k)
		{

			$base=range(0,BLOCK_SIZE-1);
			for ($i=0;$i<BLOCK_SIZE;++$i)
			{
				$r=rand(0,count($base)-1);
				$index=array_keys($base)[$r];
				$pbox[$k][$i]=$base[$index];
				unset($base[$index]);
			}
		}
	}
	$out=str_repeat(" ", BLOCK_SIZE);
	if ($reverse)
		for ($i=0;$i<BLOCK_SIZE;++$i)
			$out[$pbox[$round][$i]]=$block[$i];
	else
		for ($i=0;$i<BLOCK_SIZE;++$i)
			$out[$i]=$block[$pbox[$round][$i]];
	return $out;
}
function xbox($block,$key)
{
	$out=str_repeat(" ", BLOCK_SIZE);
	for ($i=0;$i<BLOCK_SIZE;++$i)
		$out[$i]=chr( (ord($block[$i])^ord($key[$i]))%256 );
	return $out;
}
function ps2_block($block,$key,$decrypt=false)
{
	$key=hex2bin(md5($key));
	$key=pad($key,BLOCK_SIZE);

	if ($decrypt)
		for ($i=ROUNDS-1;$i>=0;--$i)
		{
			$roundkey=$key;
			if (defined("PLUS"))
				$roundkey=pad(md5($key.$i),BLOCK_SIZE);
			$block=xbox($block,$roundkey,$i,$decrypt);
			$block=pbox($block,$i,$decrypt);
			$block=sbox($block,$i,$decrypt);
		}
	else //encrypt
		for ($i=0;$i<ROUNDS;++$i)
		{
			$roundkey=$key;
			if (defined("PLUS"))
				$roundkey=pad(md5($key.$i),BLOCK_SIZE);
			$block=sbox($block,$i,$decrypt);
			$block=pbox($block,$i,$decrypt);
			$block=xbox($block,$roundkey,$i,$decrypt);
		}
	return $block;
}
function ps2($message,$key,$decrypt=false)
{
	$msg=pad($message,BLOCK_SIZE);
	$blocks=str_split($msg,BLOCK_SIZE);
	$res=[];
	foreach ($blocks as $block) //ECB mode
		$res[]=ps2_block($block,$key,$decrypt);
	return implode($res);
}