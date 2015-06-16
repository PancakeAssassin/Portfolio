<?php
session_start();
require_once('dbFunc.php');
require_once('page.php');
require_once('adminFunc.php');

$page= new Page();


if(DeleteUser($_POST['customerid'], 'customer'))
{
	$page->content= "Customer removed from database";
}
else
{
	$page->content= "Unable to remove customer from database";
}

$page->Display();
?>