<?php

function filledOut($formVars)
{
	//test that each variable has a value
	foreach($formVars as $key => $value)
	{
		if((!isset($key)) || ($value ==''))
		{
			return false;
		}
	}
	return true;
}

function validEmail($address)
{
	if(ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9_\.\-]+\.[a-zA-Z0-9_\.\-]+$", $address))
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>