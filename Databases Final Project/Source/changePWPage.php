<?php
session_start();
require_once('authFunc.php');
require_once('page.php');

$page= new Page();

$page->content="<h2>Change Password</h2> <br />
		".changePWForm()."";
		
$page->Display();

?>