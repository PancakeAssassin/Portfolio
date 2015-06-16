<?php
session_start();
require('page.php');
require('dataValid.php');
require('adminFunc.php');

$page= new Page();

$username= $_POST['username'];
$street= $_POST['street'];
$city= $_POST['city'];
$state= $_POST['state'];
$zip= $_POST['zip'];
$email= $_POST['email'];

if(filledOut($_POST))
{
	echo $_POST['customerid'];


	if(UpdateCustomer($_POST['customerid'], $username, $street, $city, $state, $zip, $email))
	{
		$page->content= "User:<em> ".stripslashes($username)."</em> updated.";
	}
	else
	{
		$page->content= "User:<em> ".stripslashes($username)."</em> could not be updated. Please try again later.";
	}
}
else
{
	$page->content= "The form was not filled out correctly. Please try again.";
}

$page->Display();

?>