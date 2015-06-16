<?
 require_once("page.php");
 require_once("dbFunc.php");
 require_once('item.php');
    
    class OrdersPage extends Page
    {
    	public function Display()
    	{
    		//<head> tag
        	echo "<html>\n<head>\n";
        	$this->DisplayTitle();
        	$this->DisplayKeywords();
        	$this->DisplayStyles();
        	echo "</head>\n<body>\n";
        	//<body> tag
        	$this->DisplayHeader();
        	$this->DisplayCart();
        	$this->DisplaySearch();
        	$this->DisplayMenu($this->buttons);
        	$this->DisplayOrders();
        	$this->DisplayFooter();
        	echo "</body>\n</html>\n";
    	}
   	 public function DisplayOrders()
   	 {
   	 	
   	 	
   	 	$db= dbConnect();
   	 	
   	
   	 	$query= "select *
   	 		 from orders";

   	 	
   	 	$result= $db->query($query);
   	 	
   	 	$num_results= $result->num_rows;
   	 	
   	 	echo "<p>Number of orders retrieved: ".$num_results."</p>";
   	 	
   	 	for($i= 0; $i < $num_results; $i++)
   	 	{
   	 		$row= $result->fetch_assoc();
   	 		echo "<table>
   	 		<tr>
   	 		<th>".($i+1)." "." OrderID: </th>
   	 		<td><a href=\"orderItems.php?orderid=".$row['orderid']."\">".$row['orderid']."</a></td>
   	 		</tr>
   	 		<tr>
   	 		<th>
   	 			Customer: 
   	 		</th>
   	 		<td>
   	 			".$row['shipName']."
   	 		</td>
   	 		</tr>
   	 		<tr>
   	 		<th>
   	 			Order Made:
   	 		</th>
   	 		<td>
   	 			".$row['orderdate']."
   	 		</td>
   	 		</tr>
   	 		<tr>
   	 		<th>
   	 			Total:
   	 		</th>
   	 		<td> 
   	 			".$row['totalcost']."
   	 		</td>
   	 		</tr>
   	 		<tr>
   	 		<th>
   	 			Order Status:
   	 		</th>
   	 		<td>
   	 			".$row['orderstatus']."
   	 		</td>
   	 		</tr>
   	 		</table>
   	 		<br />";
   	 		
   	 	}
   	 	
   	 	$result->free();
   	 	$db->close();
   	 }
  }
  $page= new OrdersPage();
  $page->Display();
?>