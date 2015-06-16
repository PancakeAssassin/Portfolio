<?php
session_start();
	require_once('page.php');
	require_once('dbFunc.php');
	require_once('item.php');
	
	$page= new Page();
	
	$id= $_GET['orderid'];
	
	$db= dbConnect();
	
	$query= "select * from orderitems
		where orderid=".$id."";
	
	$result= $db->query($query);
	
	$numres= $result->num_rows;
	
	$page->content= "<h3>Order ".$id." Items</h3>
			Number of unique items found: ".$numres."";
	$page->content.="<form action=\"shipped.php\" >
			<input type=\"hidden\" name=\"orderid\" value=".$id.">
			<input type=\"submit\" value=\"Order Shipped\">
			</form>";
	
	for($i= 0; $i<$numres; $i++)
	{
		$row= $result->fetch_assoc();
		$query="select * from merchandise
			where itemid=".$row['itemid']."";
		
		$item= $db->query($query);
		
		$page->content.="<table width= \"25\%\">
			<tr><th>Item</th><td>".($i+1)."</td>";
		
		if(!$result)
		{
			$page->content.= "Item number ".$row['itemid']."not found.";
		}
		else
		{
			$itemrow= $item->fetch_assoc();
			$page->content.= "<tr><th>Name</th><td>".$itemrow['name']."</td></tr>
					<tr><th>Itemid</th><td>".$row['itemid']."</td></tr>
					<tr><th>Specid</th><td>".$row['specid']."</td></tr>
					<tr><th>Quantity</th><td>".$row['quantity']."</td></tr>
					</table>
					<br />";		
		}
	}
	
	$page->Display();
	
?>