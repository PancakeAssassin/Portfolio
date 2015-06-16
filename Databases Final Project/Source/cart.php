<?
	session_start();
	
	if(!isset($_SESSION['valid_user']))
	{
      		header("Location: home.php");
      		exit;
	} 
	
	require_once("page.php");
	require_once("itemFunc.php");
	require_once("item.php");
	require_once("cartForm.php");
	
	
	class CartPage extends Page
	{
		public $newitem;
		public $newspec;
		
		public function Display()
		{
	
			$this->title= "Hockey Heaven: Your shopping cart";
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
				
        		$this->UpdateCartItems();
        		$this->DisplayFooter();
        		echo "</body>\n</html>\n";  
        	}
        	
        	public function UpdateCartItems()
        	{
	
			if($this->newitem)
			{
				if(!isset($_SESSION['cart']))
				{
					$_SESSION['cart']= array();
					$_SESSION['items']= 0;
					$_SESSION['totalPrice']= 0.0;
				}
				if(isset($_SESSION['cart'][$this->newitem."".$this->newspec]))
				{
					$another= new Item();
					$another= unserialize($_SESSION['cart'][$this->newitem."".$this->newspec]);
					$another->qty++;
					$_SESSION['cart'][$this->newitem."".$this->newspec]= serialize($another);
					unset($another);
				}
				else
				{
					$theitem= new Item();
					$theitem->itemid= $this->newitem;
					$theitem->specid= $this->newspec;
					$theitem->qty= 1;
					
					$_SESSION['cart'][$this->newitem."".$this->newspec]= serialize($theitem);
					unset($theitem);
				/*
					$_SESSION['cart'][$this->newitem."".$this->newspec]= new Item();
					$_SESSION['cart'][$this->newitem."".$this->newspec]->itemid=$this->newitem;
					$_SESSION['cart'][$this->newitem."".$this->newspec]->specid=$this->newspec;
					$_SESSION['cart'][$this->newitem."".$this->newspec]->qty= 1;
					
					echo $this->newitem."".$this->newspec;
					*/
				}
		
				$_SESSION['totalPrice']= calculatePrice($_SESSION['cart']);
				$_SESSION['items']= calculateItems($_SESSION['cart']);
			}
			
			if(isset($_POST['save']) && isset($_SESSION['cart']))
			{
				$item= new Item();
				
				
				foreach($_SESSION['cart'] as $itemid=>$value)
				{					
						if($_POST[$itemid] == '0')
						{
							unset($_SESSION['cart'][$itemid]);
						}
						else
						{
							$item= unserialize($_SESSION['cart'][$itemid]);
							$item->qty= $_POST[$itemid];
							$_SESSION['cart'][$itemid]=serialize($item);
						}
				}
				$_SESSION['totalPrice']= calculatePrice($_SESSION['cart']);
				$_SESSION['items']= calculateItems($_SESSION['cart']);
			}
			
			
			if(($_SESSION['cart']) )
			{
				$this->content=DisplayCartItems($_SESSION['cart'], $_SESSION['totalPrice'], $_SESSION['items']);
				echo $this->content;

			}
			else
			{
				echo "<p>There are no items in your cart </p>";
			}
			?>
			<br />
			<table>
			<tr>
				<td>
					<form action="home.php">
						<input type="submit" value="Continue Shopping" />
					</form>
				</td>
				<td>
					<form action="checkout.php">
						<input type="submit" value="Checkout" />
					</form>
				</td>
			</tr>
			</table>
			<?
        	}
        	
        	
        	
	}
	


	$new= $_GET['new'];
	$spec= $_GET['extras'];
	
	$page= new CartPage();
	
	
	$page->newitem= $new;
	$page->newspec= $spec;
	$page->Display();

?>