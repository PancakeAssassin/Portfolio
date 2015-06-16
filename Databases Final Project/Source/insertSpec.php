<?php
session_start();

require_once('adminFunc.php');
require_once('page.php');

$page= new Page();

if(isset($_GET))
{
	echo $_GET['catname'];
	if(insertSpec($_GET))
	{	
		$page->content= "Item specialization created.";
	}
	else
	{
		$page->content= "Unable to create item specialization.";
	}
}

$page->Display();
?>