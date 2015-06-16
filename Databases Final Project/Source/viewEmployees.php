<?php
session_start();

require_once('dbFunc.php');
require_once('page.php');
require_once('adminFunc.php');

$page=new Page();

$page->content= getEmployees();

$page->Display();

?>