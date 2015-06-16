<?php
session_start();
require_once('dbFunc.php');
require_once('page.php');
require_once('adminFunc.php');

$page= new Page();

echo $_POST['employeeid'];

if(DeleteUser($_POST['employeeid'], 'employee'))
{
	$page->content= "Employee removed from database";
}
else
{
	$page->content= "Unable to remove employee from database";
}

$page->Display();
?>