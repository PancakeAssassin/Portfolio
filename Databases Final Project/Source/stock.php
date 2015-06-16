<?php
session_start();
require_once("dbFunc.php");
require_once('page.php');
require_once('itemFunc.php');
require_once('financeFunc.php');

$page= new Page();

$page->content= getMerchandise();

$page->Display();
?>