<?php

require_once('dbFunc.php');

function login($username, $pwd, $accountType)
{
	$db= dbConnect();
	
	//check username and password
	
	
	
		if($accountType == 'customer')
		{
			$query= "select * from customer 
				where username=\"".$username."\" and
				password= \"".sha1($pwd)."\"";
		}
		else
		{
			$query= "select * from employees
				where username=\"".$username."\" and 
				password=\"".sha1($pwd)."\" and 
				category= \"".$accountType."\"";
		}
		
		$result=$db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		if($result->num_rows == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
}

function isAdmin()
{
	if($_SESSION['AccountType']== 'admin')
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isShipping()
{
	if($_SESSION['AccountType'] == 'shipping')
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isFinance()
{
	if($_SESSION['AccountType'] == 'finance')
	{
		return true;
	}
	else
	{
		return false;
	}
}

function loginform()
{
   return "<form action= \"dblogin.php\" method=\"post\">
   	Username:<br/>
        <input type=\"text\" name=\"username\"><br/>
        Password:<br/>
        <input type=\"password\" name=\"pwd\"><br/>
        Account Type:
        <select name=\"accountType\">
        	<option value=\"customer\">Customer</option>
        	<option value=\"shipping\">Shipping</option>
        	<option value=\"finance\">Finance</option>
        	<option value=\"admin\">Administrator</option>
        </select>
        <input type=\"submit\" value=\"Log In\">
        </form>";
}

function changePW($username, $oldPw, $newPw, $accountType)
{
	//change the password from old to new
	if(login($username, $oldPw, $accountType))
	{
		$db= dbConnect();
		
		if(!$db)
		{
			return false;
		}
		
		if($accountType == 'customer')
		{
			$query="update customer
			set password = \"".sha1($newPw)."\"
			where username= \"".$username."\"
			and password=\"".sha1($oldPw)."\"";
			$result= $db->query($query);
			if(!$result)
			{
				return false; //not changed
			}
			else
			{	
				return true; //changed
			}
		}
		else
		{
			$query="update employees
			set password=\"".sha1($newPw)."\"
			where username=\"".$username."\"
			and password=\"".sha1($oldPw)."\"";
			$result= $db->query($query);
			if(!$result)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	
	}
	else
	{
		echo "unable to login";
		return false; //wrong oldPw
	}
}

function changePWForm()
{
   return "<form action= \"changePW.php\">
   	<table>
   	<tr>
   		<td class=\"graybg\">
   		New password
   		</td>
	   	<td class=\"graybg\">
	   		<input type=\"password\" name=\"newPW\">
   		</td>
   	</tr>
   	<tr>
   	   	<td class=\"graybg\">
   		Re-enter new password
   		</td>
   		<td class=\"graybg\">
   			<input type=\"password\" name=\"newPW2\">
   		</td>
   	</tr>
   		<td class=\"graybg\">
   		Old Password
   		</td>
   		<td class=\"graybg\">
        		<input type=\"password\" name=\"oldPW\">
       		 </td>
        </table>
        <input type=\"submit\" value=\"Change\">
        </form>";
}

?>