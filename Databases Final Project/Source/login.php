<?php

require_once('page.php');
require_once('authFunc.php');

$page= new Page();

$page->content= "<h3> Login </h3>";
$page->content.= loginform();

$page->Display();

?>