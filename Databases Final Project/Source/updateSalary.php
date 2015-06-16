<?php
session_start();
require_once('page.php');
require_once('dataValid.php');
require_once('adminFunc.php');
require_once('financeFunc.php');

$page= new Page();

$empid= $_POST['empid'];
$amount= $_POST['paymentamount'];

if(filledOut($_POST))
{


	if(updateSalary($amount, $empid))
	{
		$page->content= "Salary updated";
	}
	else
	{
		$page->content= "Salary not updated";
	}
}
else
{
	$page->content= "The form was not filled out correctly. Please try again.";
}

$page->Display();

?>