<?php

session_start();
require_once('page.php');
require_once('adminFunc.php');
require_once('itemFunc.php');

$page= new Page();

$id= $_GET['item'];

$item= getItemDetails($id);

$page->content= MerchForm($item);

$page->Display();
?>