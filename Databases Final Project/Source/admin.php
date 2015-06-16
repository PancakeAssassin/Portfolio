<?
	session_start();
	require_once("page.php");
	require_once("authFunc.php");
	require_once('item.php');
	
	
	$page= new Page();
	
	if(isAdmin())
	{
		$page->content= "Welcome admin";
	}
	else
	{
		$page->content= "You are not authorized to enter the administration area."; 
	}
	$page->Display();
?>