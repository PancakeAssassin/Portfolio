<?php
session_start();
require('page.php');
require('dataValid.php');
require('adminFunc.php');

$page= new Page();

$username= $_POST['username'];
$pw= $_POST['pw'];
$firstname= $_POST['firstName'];
$lastname= $_POST['lastName'];
$street= $_POST['street'];
$city= $_POST['city'];
$state= $_POST['state'];
$zip= $_POST['zip'];
$email= $_POST['email'];

if(filledOut($_POST))
{
	


	if(AddCustomer($username, $pw, $firstname, $lastname, $street, $city, $state, $zip, $email))
	{
		$page->content= "User:<em> ".stripslashes($username)."</em> added to database.";
	}
	else
	{
		$page->content= "User:<em> ".stripslashes($username)."</em> could not be added to the database.";
	}
}
else
{
	$page->content= "The form was not filled out correctly. Please try again.";
}

$page->Display();

?>