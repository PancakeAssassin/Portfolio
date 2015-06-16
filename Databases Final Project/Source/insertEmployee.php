<?php
session_start();
require('page.php');
require('dataValid.php');
require('adminFunc.php');

$page= new Page();

$username= $_POST['username'];
$pw= $_POST['pw'];
$ssn= $_POST['ssn'];
$type= $_POST['category'];
$firstname= $_POST['firstName'];
$lastname= $_POST['lastName'];
$street= $_POST['street'];
$city= $_POST['city'];
$state= $_POST['state'];
$zip= $_POST['zip'];
$email= $_POST['email'];
$phone= $_POST['phone'];
$paymentamount= $_POST['paymentamount'];

if(filledOut($_POST))
{
	


	if(AddEmployee($username, $pw, $ssn, $type, $firstname, $lastname, $street, $city, $state, $zip, $email, $phone,	$paymentamount))
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