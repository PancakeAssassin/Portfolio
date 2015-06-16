<?php
session_start();
	require_once('adminFunc.php');
	require_once('page.php');
	
	
	$page= new Page();
	
	$user= getCustomer($_GET['id']);
	
	$page->content.="<h3>Customer</h3> <table><td><a href= \"viewCustomer.php\">View Customers</a></td></table>". CustomerForm($user)."";
	
	$page->Display();
	
?>