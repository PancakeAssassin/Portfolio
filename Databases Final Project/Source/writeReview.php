<?php
session_start();
require_once('reviewFunc.php');
require_once('page.php');

$id= $_GET['itemid'];

$page= new Page();

$page->content= ReviewForm($id);

$page->Display();

?>