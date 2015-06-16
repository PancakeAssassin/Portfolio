<?php
	session_start();
	require_once('page.php');
	require_once('item.php');
	require_once('cartForm.php');
	require_once('itemFunc.php');
	require_once('orderFunc.php');
	
	
	$page= new Page();
	
	$name= $_POST['name'];
	$address= $_POST['address'];
	$city= $_POST['city'];
	$state= $_POST['state'];
	$zip= $_POST['zip'];
	
	  if (($_SESSION['cart']) && ($name) && ($address) && ($city) && ($zip)) 
	  {
	  	$id= false;
	  	
   		 if($id= insertOrder($_POST)) 
   		 {

      			$page->content= DisplayCartItems($_SESSION['cart'], $_SESSION['totalPrice'], $_SESSION['totalItems'], false);
      			$page->content.= DisplayShipping(calculateShipping());
      			$page->content.=DisplayCreditCardForm($name, $id);

      			
    		} 
    		else 
    		{
      			$page->content= "Unable to store order. Please try again later";
      			
    		}
  	 } 
  	 else 
  	 {
    		$page->content= "You did not properly fill out the form. Please try again.";
  	 }
  	 
  	 $page->Display();
	

?>