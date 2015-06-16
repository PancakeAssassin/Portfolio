<?php

require_once('dbFunc.php');

function getReviews($customerid)
{

	$db= dbConnect();
	
	$query="select * from reviews 
		where customerid=".$customerid."";
		
	$result=$db->query($query);
	
	if((!$result) || ($result->num_rows < 1))
	{
		return "";
	}
	
	
	
	$reviews= "<h2>Reviews</h2>
	<table>
	<tr>
	<th>Item</th>
	<th>Score</th>
	<th>Review</th>
	</tr>";
	
	while($row= $result->fetch_assoc())
	{
		$query2="select name from merchandise
			where itemid=".$row['itemid']."";
		$result2= $db->query($query2);
		
		$row2= $result2->fetch_assoc();
		
		$reviews.="<tr>
			<td>
				<a href=\"itemPage.php?item=".$row['itemid']."\"> ".$row2['name']."</a> 
			</td>
			<td>".$row['score']."/5 </td>
			<td>
			<a href=\"reviewPage.php?customerid=".$row['customerid']."&amp&amp itemid=".$row['itemid']."\">View Review</a>
			</td>
			</tr>";			
	}
	$reviews.="</table>";
	return $reviews;
}

function getOrders($name)
{

	if(!isset($name))
	{
		return "You are not logged in. Please login to view this page.";
	}
	$db= dbConnect();

	$query= "select customerid from customer
		where username=".$name."";
	
	$result=$db->query($query);
	
	if(!isset($result) || $result->num_rows == 0)
	{
		return "Unable to access database at this time. Please try again later.";
	}
	
	$row= $result->fetch_assoc();	

	$query="select * from orders 
		where customerid=".$row['customerid']."";
		
	$result=$db->query($query);
	
	if((!$result) || ($result->num_rows < 1)) 
	{
		return "No current orders found";
	}
	
	$orders="<h2>Orders</h2>";
	
	while($row= $result->fetch_assoc())
	{
		//setup a table for the order
		$orders.="<table>
		<tr>
		<td>Order made: ".$row['orderdate']."</td>
		<td>Status: ".$row['orderstatus']."</td>
		</tr>
		<tr>
		<th>Name</th> <br/>
		<th>Specs</th>
		<th>Quantity</th>
		<th>Cost</th>
		</tr>";
	
		$query2="select * from orderitems
			where orderid=".$row['orderid']."";
		
		$result2= $db->query($query2);
		
		while($row2= $result2->fetch_assoc())
		{
			$query3="select price from merchandise 
				where itemid=".$row2['itemid']."";
			
			$result3= $db->query($query3);
			
			$price= $result3->fetch_assoc();
			
			$orders.="<tr>
			<td>
				<a href=\"itemPage.php?item=".$row2['itemid']."\"> ".$row2['name']."</a>
			</td>
			<td>
				Function to regulate specs here
			</td>
			<td>
				".$row2['quantity']."
			</td>
			<td>
				".number_format($price,2)."
			</td>
			</tr>";
		}
		$orders.="<tr>
			<th colspan=\"2\">Total</th>
			<th>".$row['totalcost']."</th>
			<th> 
			</tr>
			</table> <br /> <br />";
				
	}
	return $orders;
}

function customerDetails($name)
{

	$db= dbConnect();
	
	$query= "select * from customer
		where username=\"".$name."\"";
		
	$result=$db->query($query);
	
	$customer=$result->fetch_assoc();
	
	return $customer;
}

?>