<?php
session_start();
require_once('adminFunc.php');
require_once('page.php');

$page= new Page();

if(AddItem($_POST['itemid'], $_POST['name'], $_POST['manufacturer'], $_POST['catid'], $_POST['price'], $_POST['description']))
{
	$page->content= "Item inserted into Merchandise.";
}
else
{
	$page->content.="Item not inserted. Please try again.";
}


$page->Display();
?>