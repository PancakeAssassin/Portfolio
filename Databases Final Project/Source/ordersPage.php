<?php
session_start();
require_once('customerFunc.php');
require_once('page.php');

$page= new Page();


$page->content="<h3>".$_SESSION['valid_user']."'s Orders:</h3><br />";

$page->content=getOrders($_SESSION['valid_user']);

$page->Display();

?>