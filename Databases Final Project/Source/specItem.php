<?php
session_start();

require_once("page.php");
require_once("dbFunc.php");
require_once("item.php");
require_once("itemFunc.php");
require_once('adminFunc.php');


$page= new Page();

$page->content=insertSpecForm($_GET['item']);


$page->Display();


?>