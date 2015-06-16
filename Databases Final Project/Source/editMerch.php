<?php
session_start();
require_once('adminFunc.php');
require_once('page.php');

$page= new Page();

if(UpdateItem($_POST['olditemid'], $_POST['itemid'], $_POST['name'], $_POST['manufacturer'], $_POST['catid'], $_POST['price'], $_POST['description']))
{
	$page->content= "Item Updated.";
}
else
{
	$page->content.="Item not updated. Please try again.";
}


$page->Display();
?>