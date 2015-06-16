<?php

    require("page.php");
    require("dbFunc.php");
    
    class ResultsPage extends Page
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
			
        	echo $this->content;
        	$this->DisplaySearchResults();
        	$this->DisplayFooter();
        	echo "</body>\n</html>\n";
   	 }
   	 public function DisplaySearchResults()
   	 {
   	 	//create short variable names
   	 	$merchType= $_POST['merchType'];
   	 	$value= $_POST['value'];
   	 	
   	 	
   	 	if(!$merchType || !$value)
   	 	{
   	 		echo "Search could not be completed. You have not entered search details. Please try again.";
   	 		echo "<br /> <br /> <br /> ";
   	 		return;
   	 	}
   	 	
   	 	$db= dbConnect();
   	 	
   	 	
   	 	if($merchType == "all")
   	 	{
   	 		$query= "select * from merchandise where name like '%".$value."%'";
   	 	}
   	 	else
   	 	{
   	 		$query= "select catid from categories where catname like '%".$merchType."%'";
   	 		
   	 		$result= $db->query($query);
   	 		
   	 		if($result->num_rows == 0)
   	 		{
   	 			return false;
   	 		}
   	 		
   	 		$innerRow= $result->fetch_assoc();
   	 		
   	 		$query="select * from merchandise where catid=".$innerRow['catid']." and name like '%".$value."%'";
   	 	}
   	 	
   	 	$result= $db->query($query);
   	 	
   	 	$num_results= $result->num_rows;
   	 	
   	 	echo "<p>Number of items found: ".$num_results."</p>";
   	 	
   	 	for($i= 0; $i < $num_results; $i++)
   	 	{
   	 		$row= $result->fetch_assoc();
   	 		echo "<p><b>".($i+1)." "." Name: ";
   	 		echo "<a style=\"color:#800000\" href=\"itemPage.php?itemid=".$row['itemid']."\">".htmlspecialchars($row['name'])."</a>";
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
  $page= new ResultsPage();
  $page->Display();
?>
