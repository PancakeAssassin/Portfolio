<?php
session_start();

require_once('dbFunc.php');
require_once('page.php');
require_once('itemFunc.php');

$page= new Page();



if(!$_GET['item'])
{
	$page->content= "Item unspecified. Unable to reveal stock sheet.";
}
else
{
	$item= getItemDetails($_GET['item']);
	
	$page->content= "<h4>Update stock for ".$item['name']."</h4>
			<form action=\"addstock.php\">".CreateExtrasForm($_GET['item'])."
			<input type=\"text\" name=\"qty\">
			<input type=\"hidden\" name=\"itemid\" value=".$_GET['item'].">
			<input type=\"submit\" value=\"Update Stock\">
			</form>";
}

$page->Display();

?>