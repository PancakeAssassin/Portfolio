<?php
session_start();
require_once('adminFunc.php');
require_once('page.php');

$page= new Page();

if(DeleteItem($_POST['itemid']))
{
	$page->content= "Item deleted.";
}
else
{
	$page->content.="Item not deleted. Please try again.";
}


$page->Display();
?>