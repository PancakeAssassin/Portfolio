<?php
require_once('item.php');


function dbConnect()
{
	@ $result= new mysqli('localhost', 'mindac_mindac' , 'saints19' ,'mindac_HH');
	
	if(mysqli_connect_errno())
   	 {
   	 		echo "Error: Could not connect to database. Please try again later.";
   	 		exit;
   	 }
   	 
   	 $result->autocommit(TRUE);
   	 
	return $result;
}

function dbResultArray($result)
{
	$resultarray= array();
	
	for($count=0; $row= $result->fetch_assoc(); $count++)
	{
		$resultarray[$count]= $row;
	}
	
	return $resultarray;
}

?> 	 	