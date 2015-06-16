<?php
	session_start();
	require('page.php');
	require('adminFunc.php');
	
	$page= new Page();
	
	$page->content= CategoryForm();
	
	$page->Display();

?>