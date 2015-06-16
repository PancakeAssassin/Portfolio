<?php

session_start();
require_once('customerFunc.php');
require_once('reviewFunc.php');
require_once('page.php');

$page= new Page();

$customer= customerDetails($_SESSION['valid_user']);


if(submitReview($_POST['itemid'], $customer['customerid'], $_POST['score'], $_POST['blurb']))
{
	$page->content= "Review submitted.";
}
else
{
	$page->content="Unable to submit review. Please try again later.";
}

$page->Display();
?>