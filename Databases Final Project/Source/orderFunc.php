<?php

require_once('dbFunc.php');
require_once('item.php');

function processCC($cardDetails)
{
	return true;
}

function insertOrder($address)
{
	extract($address);
	
	
	$db= dbConnect();
	
	$db->autocommit(FALSE);
	
	//insert customer address
	$query="select customerid from customer 
	where username=\"".$_SESSION['valid_user']."\"";
	
	$result= $db->query($query);
	
	if($result->num_rows>0)
	{
		$customer= $result->fetch_assoc();
		$customerid= $customer['customerid'];
	}
	else
	{
	echo "Unable to find cutomer";
		return false;
		/*$query= "insert into customers values
		firstName=\"".$firstName."\",
		lastName=\"".$lastName."\",
		street=\"".$address."\",
		city=\"".$city."\",
		st=\"".$state."\",
		zip=\"".$zip."";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}*/
	}
	
	
	$date= date("Y-m-d");
	
	
	//insert general order and shipping info
	$query= "insert into orders values
		('',".$customerid.", ".$_SESSION['totalPrice'].", \"".$date."\", \"Processing\",\"".$name."\", \"".$address."\", \"".$city."\", \"".$state."\", \"".$zip."\")";
		
	$result= $db->query($query);
	if(!$result)
	{
		echo "unable to insert order";
		return false;
	}
	
	$query= "select orderid from orders where
		customerid=".$customerid." and
		totalcost >(".$_SESSION['totalPrice']."-.001) and 
		totalcost <(".$_SESSION['totalPrice']."+.001) and
		orderdate=\"".$date."\" and
		shipName=\"".$name."\" and
		shipAddress=\"".$address."\" and 
		shipCity=\"".$city."\" and
		shipState=\"".$state."\" and
		shipZip=\"".$zip."\"";
		
	$result= $db->query($query);
	
	if($result->num_rows>0)
	{
		$order= $result->fetch_object();
		$orderid= $order->orderid;
	}
	else
	{
		echo "unable to find orderid";
		return false;
	}
	
	//insert each item
	foreach($_SESSION['cart'] as $itemid=>$quantity)
	{
		$i= unserialize($_SESSION['cart'][$itemid]);
		$item= getItemDetails($i->itemid);
		$query= "delete from orderitems where
			orderid= ".$orderid." and specid=\"".$i->specid."\" and itemid = ".$i->itemid."";
		$result= $db->query($query);
		
		$query="insert into orderitems values
		(".$orderid.",".$i->itemid.",\"".$i->specid."\",".$item['price'].",".$i->qty.")";
		
		$result= $db->query($query);
	
		if(!$result)
		{
			echo "unable to insert order item";
			return false;
		}
		
		$cat= getCategoryName($item['catid']);
		
		echo $cat;
		
		$query= "update ".strtolower($cat)."
			set quantity= quantity-".$i->qty." 
			where itemid=".$i->itemid." and exId=\"".$i->specid."\"";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
	}	
	
	$db->commit();
	$db->autocommit(TRUE);
	
	return $orderid;
}

function updateOrder($id, $status)
{
	if($id== '')
	{
		return false;
	}
	
	$db= dbConnect();
	
	$query= "update orders 
		set orderstatus=\"".$status."\"
		where orderid=".$id."";
	
	$result= $db->query($query);
	
	if(!$result)
	{
		return false;
	}	
	
	return true;
}

?>