<?php
session_start();

require_once("page.php");
require_once("dbFunc.php");
require_once("orderFunc.php");

$page= new Page();


if(updateOrder($_GET['orderid'], "Shipped"))
{
	$page->content= "Order has been updated to \"Shipped\"";
}
else
{
	$page->content= "Unable to update order.";
}

$page->Display();

?>