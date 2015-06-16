<?php
	require_once('dbFunc.php');
	

	function addToItemQuantity($itemid, $specid, $qty)
	{
		$db= dbConnect();
		
		$query= "select catid
			from merchandise 
			where itemid=".$itemid."";	
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		$row= $result->fetch_assoc();
		$cat= getCategoryName($row['catid']);
		
		$query= "update ".$cat."
		set quantity= quantity+".$qty."
		where itemid=".$itemid." and exId=\"".$specid."\"";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		return true;
	}
	
	function updateSalaryForm($emp)
	{
		$form= "<table><form action=\"updateSalary.php\" method=\"post\">
			<tr><th>Employee:</th><td>".$emp['firstName']." ".$emp['lastName']."</td></tr>
			<tr><th>Payment Amount: <br />
			(".$emp['paymenttype'].")</th><td><input type=\"text\" name=\"paymentamount\" value=".$emp['paymentamount']."></td></tr>
			<input type=\"hidden\" name=\"empid\" value=".$emp['employeeid'].">
			<tr><th></th><td><input type=\"submit\" value=\"Change Pay\"></td></tr>
			</form></table>";
		
		return $form;
	}
	
	function updateSalary($amount,$id)
	{
		$db= dbConnect();
		
		$query= "update employees set
			paymentamount=".$amount."
			where employeeid=".$id."";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		return true;
	}
	
	function getMerchandise()
	{
		$db= dbConnect();
		
		$query= "select * from merchandise";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		$items= "";
		
		while($item= $result->fetch_assoc())
		{
			$items.="<table width=\"30\%\">
			<tr><th>Item ".$item['itemid'].": ".$item['name']."</th>
			<td><form action=\"financeitem.php\"> <input type=\"hidden\" name=\"item\" value=".$item['itemid']."><input type=\"submit\" value=\"Edit Item\"></form></td></tr>
			<tr><th>Price:</th><td>".$item['price']."</td></tr>
			<tr><th>Manufacturer:</th><td>".$item['manufacturer']."</td></tr>
				     </table> <br />";
		}
		
	return $items;
	}
	
	
?>