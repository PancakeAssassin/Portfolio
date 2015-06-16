<?php
session_start();

if(!isset($_SESSION['valid_user']))
{
      header("Location: home.php");
      exit;
} 
    require_once("page.php");
    require_once("dbFunc.php");
    require_once("authFunc.php");
    require_once("item.php");
    require_once("itemFunc.php");
    require_once("reviewFunc.php");
    
    class ItemPage extends Page
    {
        public $name;
        public $manu;
        public $price;
        public $desc;
        public $extrasform;
        
        public function Display()
        {
        

            //<head> tag
            $this->CreateExtrasForm($_GET['itemid']);
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
            
            $this->DisplayItemInfo($_GET['itemid']);
            echo $this->content;
            $this->DisplayFooter();
            echo "</body>\n</html>\n";
        }
        
        public function DisplayItemInfo($id)
        {
        	
        	$row= getItemDetails($id);
        	
        	$this->name= $row['name'];
        	$this->manu= $row['manufacturer'];
        	$this->price= $row['price'];
        	$this->desc= $row['description'];
            	$this->content= "<table>
                <tr>
                    <td>
                        <img src= \"Images/".$this->name.".jpg\" width=\"180\" height=\"180\"/>
                    </td>
                    <td>
                        <b>".$this->name."</b><br/>
                        Made by:".$this->manu."<br/>
                        Price:\$".$this->price."<br/>
                        Review Score: ".getReviewScore($id)."                    
                        <form action=\"writeReview.php\">
                        <input type=\"hidden\" name=\"itemid\" value=\"".$id."\">
                    	<input type=\"submit\" value=\"Review this item\">
                    </form>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <form action=\"cart.php\">
                        <input type=\"hidden\" name=\"new\" value=".$id.">
                            ".$this->extrasform."
                            <input type=\"submit\" value=\"Add to Cart\">
                        </form>";
                if(isAdmin())
                {
                	$this->content.="<form action=\"adminitem.php\">
                		<input type=\"hidden\" name=\"item\" value=".$id.">
                		<input type=\"submit\" value=\"Edit Item\">
                		</form>";
                }
                if(isFinance())
                {	
                	$this->content.="          		<form action=\"financeitem.php\">
                		<input type=\"hidden\" name=\"item\" value=".$id.">
                		<input type=\"submit\" value=\"Edit Item\">
                		</form>";
					$this->content.="<form action=\"specItem.php\">
                		<input type=\"hidden\" name=\"item\" value=".$id.">
                		<input type=\"submit\" value=\"Add Specs\">
                		</form>";
                }
                $this->content.="</td>
                </tr>
                </table>
                <p>
                ".$this->desc." 
                </p>
                <br />
                ".getReviews($id)."";
        }
        
        
       public function CreateExtrasForm($id)
        {
        
            //need to insert results of query
            $row= getItemDetails($id);
            
            $catname= getCategoryName($row['catid']);
            
            $db= dbConnect();
            
            
            $query= "select * from ".strtolower($catname)."
            	     where itemid=".$id."";
            
            $result=$db->query($query);
            if(!$result)
            	return false;
            
            $num_results= $result->num_rows;
            
            $this->extrasform= "<select name=\"extras\">";
            while($row= $result->fetch_assoc())
            {
            	if($row['quantity'] > 0)
            	{
                	$this->extrasform.= "<option value=".$row['exId'].">";
                	foreach($row as $key=>$value)
                	{
                    		if($key != 'exId' && $key != 'quantity' && $key != 'itemid' &&  $value != 'Practice')
                        		$this->extrasform.= $value." ";
                	}
               $this->extrasform.="</option>";
        	}
            }
            $this->extrasform.="</select>";
        }
        
      
      
        
    }
    $page= new ItemPage();
    
    $page->Display();

?>

