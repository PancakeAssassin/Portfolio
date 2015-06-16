<?php
session_start();

if(!isset($_SESSION['valid_user']))
{
      header("Location: home.php");
      exit;
} 

require_once('customerFunc.php');
require_once('authFunc.php');
require_once('item.php');
require_once('page.php');

$page= new Page();

$db= dbConnect();

if(isset($_SESSION['valid_user']))
{
	if($_SESSION['AccountType'] == 'customer')
	{
		$query= "select * from customer
		where username=\"".$_SESSION['valid_user']."\"";
	}
	else
	{
		$query= "select * from employees
		where username=\"".$_SESSION['valid_user']."\"";
	}
	
	$result= $db->query($query);
	
	
	if($result->num_rows == 0)
	{
		$page->content= "Unable to access your account. Please try again later.";
	}
	else
	{
		$row= $result->fetch_assoc();
			
		//display information common among employees and customers
		$page->content="
				<h2>
				".ucfirst($_SESSION['valid_user'])."'s Account Page:  
				</h2>
				<a href=\"changePWPage.php\">Change Password</a>
				<table>
				<tr>
					<th>
						Name: 
					</th>
					<td>
					".$row['firstName']." ".$row['lastName']."
					</td>
				</tr>
				<tr>
					<th>
						Address:
					</th>
					<td>
					".$row['street']." <br />
					".$row['city'].", ".$row['st']." ".$row['zip']."<br />
					<a href=\"changeaddress.php\">Change Address</a>
					</td>
				</tr>
				<tr>
					<th>
						Email:		
					</th>
					<td>
					".$row['email']."<br />
					<a href=\"changeemail.php\">Change Email</a>
					</td>
				</tr>";
			if(isAdmin() || isShipping() || isFinance())
			{
				$page->content.="<tr>
						<th>Salary: </th>
						<td>\$".$row['paymentamount']."</td>
						</tr>";
			}
			$page->content.= "<tr>
					<th></th>
					<td>
					<a href=\"changePWPage.php\">Change Password</a>
					</td>
					</tr></table>";
			
			
			if($_SESSION['accountType'] == 'customer')
			{
				//extra information for customers
				
				$page->content.="<h2><a href=\"ordersPage.php\">View Your Orders</a></h2> <br /> <br />";
				
				$page->content.=getReviews($row['customerid']);
				
			}

	}	
}
else
{
	$page->content= "Sorry you are currently not logged in and cannot view this page.";
}

$page->Display();

?>