<?php
session_start();

require_once('page.php');
require_once('itemFunc.php');

$page= new Page();

if(!updateItemStock($_GET['itemid'], $_GET['extras'], $_GET['qty']))
{
	$page->content= "Unable to update item stock. Please try again later.";
}
else
{
	$page->content= "Stock updated.";
}

$page->Display();

?>