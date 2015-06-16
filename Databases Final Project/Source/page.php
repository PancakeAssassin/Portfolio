<?php
require_once('item.php');
require_once('authFunc.php');

class Page
{
    //the page's attributes
    public $content;
    public $title= "Hockey Heaven";
    public $keywords= "Hockey Heaven, Hockey equipment, sticks,
                        skates, gloves, helmets, jerseys";
    
    //buttons for the different web pages
    public $buttons= array("Home"=> "home.php",
    			   "Gloves"=> "gloves.php",
    			   "Helmets"=> "helmets.php",
    			   "Jerseys"=> "jerseys.php",
    			   "Skates"=> "skates.php",
    			   "Sticks"=> "sticks.php",
                           "Contact"=>"contact.php");
                           
    public $adminbuttons= array("AdminHome"=>"admin.php",
    				"Customers"=>"admincustomer.php",
    				"Employees"=>"adminemployee.php",
    				"Items"=>"adminitem.php",
    				"Categories"=>"admincategory.php");
    				
    public $shippingbuttons= array("Orders"=>"orders.php");
    
    public $financebuttons= array("Financial"=>"finance.php",
    				  "Employee Payroll"=>"viewEmployees.php",
    				"Stock"=>"stock.php");
  	
    
    //the operations for a page
    public function __set($name, $value)
    {
        $this->$name= $value;
    }
    
    //function to display the page
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
        if(!isset($_SESSION['valid_user']))
        {
        	$this->content= loginform();
        } 
        echo $this->content;
        $this->DisplayFooter();
        echo "</body>\n</html>\n";
    }
    
    //displays the title
    public function DisplayTitle()
    {
        echo "<title>".$this->title."</title>";
    }
    
    //places the keywords in  the meta tag
    public function DisplayKeywords()
    {
        echo "<meta name=\"keywords\"
                content=\"".$this->keywords."\"/>";
    }
    
    //sets the styles for the page through css
    public function DisplayStyles()
    {
        ?>
    <style>
        h1 {
            color:white; font-size:24pt; text-align:center;
            font-family: arial, sans-serif, Verdana
           }
        .menu{
            color:white; font-size:12pt; text-align:center;
            font-family: arial, sans-serif, Verdana
             }
        td{
            background:grey
             }
        td.button
        {
        	background:blue
        }
        p{
            color:black; font-size:12pt; text-align:justify;
            font-family:arial, sans-serif,Verdana
             }
        p.foot{
            color:white; font-size:9pt; text-align:center;
            font-family:arial, sans-serif, Verdana; 
            font-weight: bold
             }
        a:link, a:visited, a:active{
            color:white
             }   
        a.title{
        	color:#0055FF
        } 
    </style>
    <?php
    }
    
    public function DisplayHeader()
    {
        ?>
    <table width="100%" cellpadding="12"
           cellspacing="0" border="0">
        <tr class="button">
            <td align="left" class="button"><a href="home.php"><img src="Images/pond_hockey.jpg" width="120" height="90"/></a></td>
            <td class="button">
                <a href="home.php"><h1>Hockey Heaven</h1></a>
            </td>
            <?
            	if(isset($_SESSION['valid_user']))
            	{
            ?>
            <td align= "right" class="button"><a href="accountPage.php"><? echo $_SESSION['valid_user'] ?></a> | <a 	href="logout.php">Logout</a>
            <? }
            else
            {
            ?>
            <td align="right" class="button"><a href="login.php">Login</a>
            <? }
            ?> 
            </td>
        </tr>
    </table>
    <?php
    }
    
    public function DisplaySearch()
    {
        ?>
        <form name="search" action="searchResults.php" method="post">
            Search <select name="merchType">
                    <option value="all">All</option>
                    <option value="Gloves">Gloves</option>
                    <option value="Helmets">Helmets</option>
                    <option value="Jerseys">Jerseys</option>
                    <option value="Skates">Skates</option>
                    <option value="Sticks">Sticks</option>
                    </select>  
                    <input type="text" name="value">
                    <input type="submit" value="Go">
        </form>
        <?
    }
    
    public function DisplayCart()
    {
    	?>
    		<div style="text-align:right;">
    			<a href="cart.php" id="Shopping Cart" style="color:blue">Cart</a>
    		</div>
    	<?
    }
    
    public function DisplayMenu($buttons)
    {
        echo "<table width=\"100%\" bgcolor=\"white\"
            cellpadding=\"4\" cellspacing=\"4\">\n";
        echo "<tr>\n";
        
        //calculate the button size
        $width= 100/count($buttons);
        
        while(list($name, $url)= each($buttons))
        {
            $this->DisplayButton($width, $name, $url,
                    !$this->IsURLCurrentPage($url));
        }
        echo "</tr>\n";
        echo "</table>\n";
    }
    
    public function IsURLCurrentPage($url)
    {
        if(strpos($_SERVER['PHP_SELF'], $url)==false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function DisplayButton($width, $name, $url, $active= true)
    {
        if($active)
        {
            echo "<td width= \"".$width."%\" class=\"button\">
                  <a href=\"".$url."\">
                  <!--<img src=\"s-logo.gif\" alt=\"".$name."\" border=\"0\" /> </a>-->
                  <a href=\"".$url."\"><span class=\"menu\">".$name."</span></a>
                  </td>";
        }
        else
        {
            echo "<td width=\"".$width."%\">
                  <!--<img src=\"side-logo.gif\">-->
                  <span class=\"menu\">".$name."</span>
                  </td>";
        }
    }
    
    public function DisplayFooter()
    {
        ?>
    <table width="100%" bgcolor="blue" cellpadding="12" border="0">
        <tr>
            <td class="button">
                <p class="foot">&copy; Hockey Heaven</p>
                <p class="foot">Database project <a href="bibliography.php" >bibliography</a>.</p>
            </td>
        </tr>
    </table>
    <?php
    }
}
?>
