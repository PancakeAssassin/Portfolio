<?php
session_start();
	require_once('adminFunc.php');
	require('page.php');
	
	
	$page= new Page();
	
	$user= getEmployee($_GET['id']);
	
	$page->content.="<h3>Employee</h3><table><td><a href=\"viewEmployees.php\">Employee List</a></td></table>". EmployeeForm($user)."";
	
	$page->Display();
	
?>