<?php
session_start();
require_once('adminFunc.php');
require_once('page.php');

$page= new Page();

if(AddCategory($_POST['catname']))
{
	$page->content= "Item inserted into Categories.";
}
else
{
	$page->content.="Category not inserted. Please try again.";
}


$page->Display();
?>