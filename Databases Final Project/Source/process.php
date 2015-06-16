<?php 
	session_start();
	require_once('page.php');
	require_once('item.php');
	require_once('itemFunc.php');
	require_once('cartForm.php');
	require_once('orderFunc.php');
	
	$page= new Page();
	
	$cardType = $_POST['cardType'];
  	$cardNumber = $_POST['cardNum'];
 	$cardMonth = $_POST['month'];
  	$cardYear = $_POST['year'];
  	$cardName = $_POST['cardName'];
  	$id= $_POST['id'];

  	if(($_SESSION['cart']) && ($cardType) && ($cardNumber) &&
     		($cardMonth) && ($cardYear) && ($cardName)) 
     	{
    		$page->content=DisplayCartItems($_SESSION['cart'], $_SESSION['totalPrice'], $_SESSION['items'], false);

    		$page->content.=DisplayShipping(CalculateShipping());

    		if(processCC($_POST))
    		{
    			if(updateOrder($id, "Processing"))
    			{
         	
     				session_destroy();
      				$page->content.= "Thank you for shopping with us. Your order has been placed.";
     				$page->content.="<table><form action=\"home.php\"><input type=\"submit\" value=\"Continue Shopping\"></form></table>";
     			}
     			else
     			{
     				$page->content.="Unable to process order. Please try again later.";
     				$page->content.="<table><form action=\"purchase.php</table><input type=\"submit\" value=\"Purchase\"></form></table>";
     			}
     			
    		} 
    		else 
    		{
      			$page->content.="Card could not be processed. Please try again later.";
      			$page->content.="<table><form action=\"purchase.php</table><input type=\"submit\" value=\"Purchase\"></form></table>";
    		}
  	} 
  	else 
  	{
    		$page->content.= "<p>You did not fill in all the fields, please try again.</p><hr />";
    		$page->content.="<table><form action=\"purchase.php</table><input type=\"submit\" value=\"Purchase\"></form></table>";
  	}
  		
  		$page->Display();
?>