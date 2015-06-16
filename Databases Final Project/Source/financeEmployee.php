<?php
session_start();
require_once('adminFunc.php');
require_once('financeFunc.php');
require_once('dbFunc.php');
require_once('page.php');

$id= $_GET['id'];

$page= new Page();

$emp= getEmployee($id);

$page->content=updateSalaryForm($emp);

$page->Display();
?>