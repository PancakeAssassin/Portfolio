<?
	session_start();
	require_once("page.php");
	require_once("authFunc.php");
	require_once('item.php');
	
	
	$page= new Page();
	
	if(isFinance())
	{
		$page->content= "Welcome to the Finance homepage";
	}
	else
	{
		$page->content= "You are not authorized to enter the finance area."; 
	}
	$page->Display();
?>