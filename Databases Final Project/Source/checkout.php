<?php
	session_start();
	
	require('dbFunc.php');
	require_once('cartForm.php');
	require_once('item.php');
	require('page.php');
	
	$page= new page();
	
	
	if($_SESSION['cart'] && (array_count_values($_SESSION['cart'])))
	{
		$page->content="";
		$page->content= DisplayCartItems($_SESSION['cart'], $_SESSION['totalPrice'], $_SESSION['items'], false);
		$page->content.=DisplayCheckoutForm();
	}
	else
	{
		$page->content="Your shopping cart is empty.";
	}
	
	$page->Display();
	
?>