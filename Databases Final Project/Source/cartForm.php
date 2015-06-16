<?php
	require_once('item.php');
	require_once('customerFunc.php');
	require_once('itemFunc.php');
	
	function DisplayCartItems($cart, $totalPrice, $totalItems, $update= true)
        {
        		
        		$cartForm.="";
        		$cartForm.= "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
        		<form action=\"cart.php\" method=\"post\">
        		<tr><th colspan=\"2\" bgcolor=\"#cccccc\">Item</th>
        		<th bgcolor=\"#cccccc\">Price</th>
        		<th bgcolor=\"#cccccc\">Quantity</th>
        		<th bgcolor=\"#cccccc\">Total</th>
        		</tr>";
        		
        		$theItem= new Item();
        		//display each item as a table row
        		foreach($cart as $item)
        		{
        			$theItem= unserialize($item);
        		    	//get the item details
        			$itemdet= getItemDetails($theItem->itemid);
        			$itemSpec=getSpecItemDetails($theItem->specid, $theItem->itemid);
        			$cartForm.="<tr>";
        			$cartForm.="<td align=\"left\">";
        			if(file_exists("Images/".$itemdet['name'].".jpg"))
        			{
        				$size= GetImageSize("Images/".$itemdet['name'].".jpg");
        				if(($size[0] >0) && ($size[1] > 0))
        				{
        					$cartForm.="<img src=\"Images/".$itemdet['name'].".jpg\"
        						style=\"border: 1px solid black\"
        						width=\"".($size[0]/3)."\"
        						height=\"".($size[1]/3)."\" />";
        				} 
        			}
        			$cartForm.="</td>";
        			
        			//display the items name price and quantity being bought
        			$cartForm.="<td align=\"left\">
        				<a href=\"itemPage.php?itemid=".$theItem->itemid."\"> ".$itemdet['name']."	</a><br />".$itemSpec."</td>
        				<td align=\"center\">\$".number_format($itemdet['price'], 2)."</td>
        				<td align=\"center\">";
        			
        			//allow changes in text boxes
        			
        			$cartForm.="<input type=\"text\" name=\"".$theItem->itemid."".$theItem->specid."\" value=\"".$theItem->qty."\" size=\"3\">
        			</td>
        			<td align=\"center\">\$".number_format($itemdet['price']*$theItem->qty,2)."</td>
        			</tr>\n";
        		}
        		
        		//diplay the total row
        		$cartForm.="<tr>
        		<th colspan=\"3\" bgcolor=\"#cccccc\">&nbsp;</td>
        		<th align=\"center\" bgcolor=\"#cccccc\">".$totalItems."</th>
        		<th align=\"center\" bgcolor=\"#cccccc\">
        			\$".number_format($totalPrice,2)."</th>
        		</tr>";
        		
        		if($update)
        		{
        			$cartForm.="<tr>
        				<td colspan=\"3\">&nbsp;</td>
        				<td align=\"center\">
        				<input type=\"hidden\" name=\"save\" value=\"true\" /> 
        				<input type= \"submit\" value=\"Save Changes\" />
        				</td>
        				<td>&nbsp;</td>
        				</tr>";
        		}
        		$cartForm.="</form></table>";	
        		
        		return $cartForm;
	}
	
	function DisplayCheckoutForm()
	{
		$customer= customerDetails($_SESSION['valid_user']);
		
		$checkoutForm="";

  		$checkoutForm.= "<br />
 		 <table border=\"0\" width=\"100%\" cellspacing=\"0\">
  		<form action=\"purchase.php\" method=\"post\">
  		<tr><th colspan=\"2\" bgcolor=\"#cccccc\">Shipping Address</th></tr>
  			<tr>
    			<td>Name</td>
    			<td><input type=\"text\" name=\"name\" value=\"".$customer['firstName']." ".$customer['lastName']."\" maxlength=\"40\" size=\"40\"/></td>
  			</tr>
  			<tr>
    				<td>Address</td>
    				<td><input type=\"text\" name=\"address\" value=\"".$customer['street']."\" maxlength=\"40\" size=\"40\"/></td>
  			</tr>
 			 <tr>
    				<td>City</td>
    				<td><input type=\"text\" name=\"city\" value=\"".$customer['city']."\" maxlength=\"20\" size=\"40\"/></td>
  			</tr>
  			<tr>
    				<td>State</td>
    				<td><input type=\"text\" name=\"state\" value=\"".$customer['st']."\" maxlength=\"20\" size=\"40\"/></td>
  			</tr>
  			<tr>
    				<td>Zip Code</td>
    				<td><input type=\"text\" name=\"zip\" value=\"".$customer['zip']."\" maxlength=\"10\" size=\"40\"/></td>
  			</tr>
 		 	<tr>
 		 	<td>
 		 	
 		 	</td>
 		 	<td>
     			<input type=\"submit\" value=\"Submit Order\">
    			</td>
  			</tr>
  			</form>
  			</table> <br />";
  			
  			return $checkoutForm;

	}
	
	function DisplayShipping($shipping)
	{
		$form="<table border=\"0\" width=\"100\%\" cellspacing= \"0\">
		<tr><th align=\"left\">Shipping</td>
		<td align=\"right\">".number_format($shipping,2)."</td></tr>
		<tr><th bgcolor=\"#cccccc\" align=\"left\"> Total </th>
		<th bgcolor=\"#cccccc\" align=\"right\">\$".number_format($shipping+$_SESSION['calculatePrice'],2)."</th>
		</tr>			
			</table> <br />";
	}
	
	function DisplayCreditCardForm($name, $id= '')
	{

  		$form="<table border=\"0\" width=\"100\%\" cellspacing=\"0\">
  		<form action=\"process.php\" method=\"post\">
  		<tr><th colspan=\"5\" bgcolor=\"#cccccc\">Credit Card Details</th></tr>
  		<tr>
    		<td>Type</td>
    		<td>Card Number</td>
    		<td>Security Code</td>
    		<td>Name on card</td>
    		<td colspan=\"2\">Expiration Date<br />
    				Month/Year</td>
    		</tr>
    		<tr>
    		<td><select name=\"cardType\">
        	<option value=\"VISA\">VISA</option>
        	<option value=\"MasterCard\">MasterCard</option>
        	<option value=\"American Express\">American Express</option>
        	</select>
    		</td>
    		<td><input type=\"text\" name=\"cardNum\" value=\"\" maxlength=\"16\" size=\"40\"></td>
    		<td><input type=\"text\" name=\"seccode\" value=\"\" maxlength=\"4\" size=\"4\"></td>
    		<td><input type=\"text\" name=\"cardName\" value = \".$name.\" maxlength=\"40\" size=\"40\"></td>
    		<td>
       		<select name=\"month\">
       			<option value=\"01\">01</option>
       			<option value=\"02\">02</option>
       			<option value=\"03\">03</option>
       			<option value=\"04\">04</option>
       			<option value=\"05\">05</option>
       			<option value=\"06\">06</option>
       			<option value=\"07\">07</option>
       			<option value=\"08\">08</option>
       			<option value=\"09\">09</option>
       			<option value=\"10\">10</option>
       			<option value=\"11\">11</option>
       			<option value=\"12\">12</option>
       		</select>
       		<select name=\"year\">";
       		for ($y = date("Y"); $y < date("Y") + 10; $y++) 
       		{
         		$form.="<option value=\"".$y."\">".$y."</option>";
       		}
             	
             	$form.="</select>
             	</td>
  		</tr>

    		<td colspan=\"6\" align=\"center\">
      		<p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
      		add or remove items</strong></p>
      		<input type=\"hidden\" name=\"id\" value=".$id." >
     		<input type=\"submit\" value=\"Confirm Purchase\" >
    		</td>
  		</tr>
  		</table>";
  		
  		return $form;
	}
	

?>