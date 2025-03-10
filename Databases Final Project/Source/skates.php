<?
session_start();

if(!isset($_SESSION['valid_user']))
{
      header("Location: home.php");
      exit;
} 

 require_once("page.php");
 require_once('item.php');
 require_once("dbFunc.php");
    
    class SkatePage extends Page
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
		if(isAdmin())
        {
        	$this->DisplayMenu($this->adminbuttons);
        }
        if(isShipping())
        {
        	$this->DisplayMenu($this->shippingbuttons);
        }
        if(isFinance())
        {
        	$this->DisplayMenu($this->financebuttons);
        }
			
        	$this->DisplaySkates();
        	$this->DisplayFooter();
        	echo "</body>\n</html>\n";
    	}
   	 public function DisplaySkates()
   	 {
   	 	
   	 	
   	 	$db= dbConnect();
   	 	
   	
   	 	//find the catid of gloves
   	 	$query= "select catid from categories
   	 		where catname= \"skates\"";

   	 	
   	 	$result= $db->query($query);
   	 	
   	 	if($result->num_rows > 0)
   	 	{
   	 		$rowid= $result->fetch_assoc();
   	 	
   	 		$id= $rowid['catid'];
   	 	
   	 	
   	 	
   	 		//find all merchandise with the gloves catid
   	 		$query="select * from merchandise
   	 			where catid=".$id."";
   	 			$result= $db->query($query);
   	 	}
   	 	
   	 	$num_results= $result->num_rows;
   	 	
   	 	echo "<p>Number of skates retrieved: ".$num_results."</p>";
   	 	
   	 	for($i= 0; $i < $num_results; $i++)
   	 	{
   	 		$row= $result->fetch_assoc();
   	 		echo "<p><b>".($i+1)." "." Name: ";
   	 		echo "<a style=\"color:#800000\" href=\"itemPage.php?itemid=".$row['itemid']."\" >".$row['name']."</a>";
   	 		echo "</b><br />Manufacturer: ";
   	 		echo $row['manufacturer'];
   	 		echo "<br />ItemID: ";
   	 		echo $row['itemid'];
   	 		echo "<br /> Price: ";
   	 		echo $row['price'];
   	 		echo "</p>";
   	 	}
   	 	
   	 	$result->free();
   	 	$db->close();
   	 }
  }
  $page= new SkatePage();
  $page->Display();
?>