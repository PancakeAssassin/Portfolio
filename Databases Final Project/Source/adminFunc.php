<?
	require_once('itemFunc.php');
	require_once("dbFunc.php");
	
	
	function AddItem($itemid, $name, $manufacturer, $catid, $price, $description)
	{
		$db= dbConnect();
		
		$query= "select * from merchandise
			where itemid=".$itemid."";
			
		$result= $db->query($query);
		if(($result->num_rows!=0))
		{
		echo "itemid error";
			return false;
		}
		
		/*$query= "select catid from categories
			where catname=\"".$catname."\"";
		
		$result= $db->query($query);
		
		if((!result) || ($result->num_rows!=0))
		{
			return false;
		}
		
		$row= $result->fetch_assoc();
		
		$catid= $row['catid'];*/
		
		
		//insert item
		$query="insert into merchandise values
			(".$itemid.",
			\"".$name."\",
			\"".$manufacturer."\",
			".$catid.",
			".$price.",
			\"".$description."\")";
		
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
	
	function AddCategory($catname)
	{
		$db= dbConnect();
		
		$query= "select * from categories
			where catname=\"".$catname."\"";
		
		$result= $db->query($query);
		
		if((!$result) || ($result->num_rows!=0))
		{
			return false;
		}
		
		$query= "insert into categories values
		catname=\"".$catname."\"";
	}

 function insertSpecForm($itemid)
 {
       $item= getItemDetails($itemid);
       $cat= getCategoryName($item['catid']);
       $db= dbConnect();
       
       $query= "select * 
                from ".strtolower($cat)."";
       
       $result= $db->query($query);
       if(!$result)
       {
           return "Unable to find item at this time.";
       }
       
       $row= $result->fetch_assoc();
       
       $form="
				Insert new spec for ".$item['name']."
				<table><form action=\"insertSpec.php\">
                <input type=\"hidden\" name=\"catname\" value=\"".$cat."\">";
				
       
       foreach($row as $key=>$value)
       {
			if($key!= 'itemid')
				$form.="<tr><th>".$key.":</th><td><input type=\"text\" name=\"".$key."\"></td></tr>";
			else
				$form.="<input type=\"hidden\" name=\"itemid\" value=".$itemid.">";
       }
       
       $form.="<tr><td colspan=\"2\"><input type=\"submit\" value=\"Insert Spec\"></form></td></tr>";
	   
	   return $form;
}


function insertSpec($newSpec)
{
        $db= dbConnect();
        $insertValues="";
		$insertKeys="";
        $i= 1;
        foreach($newSpec as $key=>$value)
        {
			if($key != 'catname')
			{
                if($i!= 1)
                {
					$insertKeys.=", ";
                    $insertValues.=",  ";
                }
				$insertKeys.= $key;
				if(is_float($value) || is_int($value))
					$insertValues.= $value;
				else
					$insertValues.="\"".$value."\"";
                $i= 2;
			}
        }
       $query= "insert into ".strtolower($newSpec['catname'])." (".$insertKeys.")
           values ( ".$insertValues." )";
       
       $result=$db->query($query);
       echo mysql_error();
       if(!$result)
       {
           return false;
       }
       return true;
}	

	
	function AddEmployee($username, $pw, $ssn, $type, $firstname, $lastname, $street, $city, $state, $zip, $email, $phone, $paymentamount)
	{
		$db= dbConnect();
		
		
		$query= "select * 
			from employees
			where ssn= \"".$ssn."\" or username=\"".$username."\"";
			
		$result= $db->query($query);
		
		if((!$result) || $result->num_rows >0)
		{
			return false;
		}
		
		
		if($type == 'shipper')
		{
			$paymentType= "hourly";
		}
		else
		{
			$paymentType= 'salary';
		}
		
		

		//insert item
		$query="insert into employees set
			username=\"".$username."\",
			ssn=\"".$ssn."\",
			category=\"".$type."\",
			firstName=\"".$firstname."\",
			lastName=\"".$lastname."\",
			street=\"".$street."\",
			city=\"".$city."\",
			st=\"".$state."\",
			zip=\"".$zip."\",
			email=\"".$email."\",
			phone=\"".$phone."\",
			password=\"".sha1($pw)."\",
			paymentamount=".$paymentamount.",
			paymenttype=\"".$paymentType."\"";
		
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
	
	function AddCustomer($username, $pw, $firstName, $lastName, $street, $city, $state, $zip, $email)
	{
		$db= dbConnect();
		
		$query= "select * from customer
			where username=\"".$username."\"";
			
		$result= $db->query($query);
		if($result->num_rows!=0)
		{
			return false;
		}
		
		//insert item
		$query="insert into customer set
			username=\"".$username."\",
			firstName=\"".$firstName."\",
			lastName=\"".$lastName."\",
			street=\"".$street."\",
			city=\"".$city."\",
			st=\"".$state."\",
			zip=\"".$zip."\",
			email=\"".$email."\",
			password=\"".sha1($pw)."\"";
		
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
	
	function UpdateItem($olditemid, $itemid, $name, $manufacturer, $catid, $price, $description)
	{
		$db= dbConnect();
		
		$query="UPDATE merchandise
			set itemid= ".$itemid.",
			name= \"".$name."\",
			manufacturer= \"".$manufacturer."\",
			catid=".$catid.",
			price= ".$price.",
			description= \"".$description."\"
			where itemid= ".$olditemid."";
			
		
		$result= $db->query($query);
		
		echo mysql_error();
		
		if(!$result)
		{
			return false;
		}
		else
		{
			return true;
		}
		
	}
	
	function UpdateEmployee($employeeid, $street, $city, $state, $zip, $email, $phone, $paymentamount)
	{
		$db= dbConnect();
		
		$query="update employees set
			street=\"".$street."\",
			city=\"".$city."\",
			st=\"".$state."\",
			zip=\"".$zip."\",
			email=\"".$email."\",
			phone=\"".$phone."\",
			paymentamount=".$paymentamount."
			where employeeid=".$employeeid."";
		
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
	
	function UpdateCustomer($customerid, $username, $street, $city, $state, $zip, $email)
	{
		$db= dbConnect();
		
		$query="update customer set
			username=\"".$username."\",
			street=\"".$street."\",
			city=\"".$city."\",
			st=\"".$state."\",
			zip=\"".$zip."\",
			email=\"".$email."\"
			where customerid=".$customerid."";
		
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
	
	function UpdateCategory($catid, $catname)
	{
		$db= dbConnect();
		
		$query= "update categories 
		set catname=\"".$catname."\"
		where catid=".$catid."";
		
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
	
	function DeleteItem($itemid)
	{
		//deletes item identified by $itemid from the database
		$db= dbConnect();
		
		$query= "delete from merchandise
			where itemid=".$itemid."";
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
	
	function DeleteItemSpecialization($itemid, $exid, $catname)
	{
		//finds all of the specializations
		$db= dbConnect();
		
		$query= "delete from ".$catname."
		where itemid=".$itemid." and exID=\"".$exid."\"";
		
		
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
	
	function DeleteUser($id, $accountType)
	{
		$db= dbConnect();
		
		if($accountType== 'customer')
		{
			$query= "delete from customer
			where customerid=".$id."";
		}
		else
		{
			$query= "delete from employees
			where employeeid=".$id."";
		}
		
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
	
	function DeleteCategory($catname)
	{
		$db= dbConnect();
		
		$query= "delete from categories
			where catname\"=".$catname."\"";
		
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
	
	function MerchForm($item= '')
	{
		
		$file= $item? 'editMerch.php': 'insertMerch.php';
		$itemid= $item?$item['itemid']:'';
		$name= $item?$item['name']:'';
		$manufacturer= $item?$item['manufacturer']:'';
		$cost= $item?$item['price']:'';
		$desc= $item?$item['description']:'';
		$submission= $item? 'Update': 'Add';
	
		$edit= is_array($item);
		//if passed an existing item, proceed in edit mode
		$form= "<form method=\"post\"
			action=\"".$file."\">
			<table border=\"0\">
			<tr>
				<td>ItemID:</td>
				<td><input type=\"text\" name=\"itemid\" 
				value=".$itemid."> </td>
			</tr>
			<tr>
				<td>Item Name:</td>
				<td><input type=\"text\" name=\"name\"
				value=\"".$name."\"> </td>
			</tr>
			<tr>
				<td>Manufacturer:</td>
				<td><input type=\"text\" name=\"manufacturer\"
				value=\"".$manufacturer."\"> </td>
			</tr>
			<tr>
			<td>Category:</td>
			<td><select name=\"catid\">";
			
			$result=getCategories();
			
			$num_cat= $result->num_rows;
			for($i=0; $i<$num_cat; $i++)
			{
				$row= $result->fetch_assoc();
				$form.= "<option value=".$row['catid']."";
				
				$form.=">".$row['catname']."</option>";
				
			}
			
			
			$form.="</tr>
			<tr>
				<td>Price:</td>
				<td><input type=\"text\" name=\"price\"
				value=\"".$cost."\"> </td>
			</tr>
			<tr>
				<td>Description:</td>
				<td><textarea rows=\"3\" cols=\"50\" name=\"description\">
				".$desc."</textarea>
			</tr>
			<tr>";
			
			if(!$edit)
			{
				$form.="<td colspan=\"2\" align=\"center\">";
			}
			else
			{
				$form.="<td align=\"center\"><input type=\"hidden\" name=\"olditemid\"
				value=".$item['itemid']." />";
			}
			
			$form.="<input type=\"submit\" value=\"".$submission." Item\" />
			</form></td>";
			
			if($edit)
			{
				$form.="<td>
					<form method=\"post\" action=\"deleteItem.php\">
					<input type=\"hidden\" name=\"itemid\"
					value=".$item['itemid']." />
					<input type=\"submit\" value=\"Delete item\" />
					</form></td>";
			}
			
			$form.="</td>
				</tr>
				</table>";
				
			
		
		return $form;
	}
	
	function CategoryForm($cat= '')
	{
	
		//$edit= is_array($cat);
		
		
		$form="";
		
		$submitTo=$cat? 'editCat.php':'insertCat.php';
		$name= $cat?$cat['catname']:'';
		//if passed an existing item, proceed in edit mode
		$form.= "<form method=\"post\"
			action=\"".$submitTo."\">
			<table border=\"0\">
			<tr>
				<td>Category Name:</td>
				<td><input type=\"text\" name=\"catname\" 
				value=\"".$cat['catname']."\"> </td>
			</tr>
			<tr>";
			
			if(!$edit)
			{
				$form.="<td colspan=\"2\" align=\"center\">";
			}
			else
			{
				$form.="<td align=\"center\"><input type=\"hidden\" name=\"catid\"
				value=\"".$cat['catid']."\" />";
			}
			
			
			$submission= $edit? 'Update': 'Add';
			
			$form.="<input type=\"submit\" value=\"".$submission." Category \"/>
			</form></td>";
			
			if($edit)
			{
				$form.="<td>
					<form method=\"post\" action=\"deleteCat.php\">
					<input type=\"hidden\" name=\"catid\"
					value=\"".$category['catid']."\" />
					<input type=\"submit\" value=\"Delete Category\" />
					</form></td>";
			}
			
			$form.="</td>
				</tr>
				</table>";
			
		
		return $form;
	}
	
	function CustomerForm($user= '')
	{
	
		$edit= is_array($user);
		
		$file= $edit? 'editCustomer.php': 'insertCustomer.php';
		$username= $edit?$user['username']:'';
		$firstName= $edit?$user['firstName']:'';
		$lastName= $edit?$user['lastName']:'';
		$street= $edit?$user['street']:'';
		$city= $edit?$user['city']:'';
		$state= $edit?$user['st']:'';
		$zip= $edit?$user['zip']:'';
		$email=$edit?$user['email']:'';
		$pass=$edit?$user['password']:'';
		
		
		//if passed an existing item, proceed in edit mode
		$form= "<form method=\"post\"
			action=\"".$file."\">
			<table border=\"0\">
			<tr>
				<td>Username:</td>
				<td><input type=\"text\" name=\"username\" 
				value=\"".$username."\"> </td>
			</tr>
			<tr>
				<td>First Name:</td>
				<td><input type=\"text\" name=\"firstName\"
				value=\"".$firstName."\"> </td>
			</tr>
			<tr>
				<td>Last Name:</td>
				<td><input type=\"text\" name=\"lastName\"
				value=\"".$lastName."\"> </td>
			</tr>
			<tr>
				<td>Street:</td>
				<td><input type=\"text\" name=\"street\"
				value=\"".$street."\"> </td>
			</tr>
			<tr>
				<td>City:</td>
				<td><input type=\"text\" name=\"city\"
				value=\"".$city."\"> </td>
			</tr>
			<tr>
				<td>State:</td>
				<td><input type=\"text\" name=\"state\"
				value=\"".$state."\"> </td>
			</tr>
			<tr>
				<td>Zip Code:</td>
				<td><input type=\"text\" name=\"zip\"
				value=\"".$zip."\"> </td>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td><input type=\"text\" name=\"email\"
				value=\"".$email."\"> </td>
			</tr>";
			if(!$edit)
			{
				$form.="<tr>
				<td>Password:</td>
				<td><input type=\"text\" name=\"pw\"
				value=\"\"> </td>
				</tr>";
			}
			
			
			
			if(!$edit)
			{
				$form.="<td colspan=\"2\" align=\"center\">";
			}
			else
			{
				$form.="<td align=\"center\"><input type=\"hidden\" name=\"customerid\"
				value=".$user['customerid']." />";
			}
			
			$submission= $edit?'Update':'Add';
			
			$form.="<input type=\"submit\" value=\"".$submission." Customer\" />
			</form></td>";
			
			if($edit)
			{
				$form.="<td>
					<form method=\"post\" action=\"deleteCustomer.php\">
					<input type=\"hidden\" name=\"customerid\"
					value=".$user['customerid']." />
					<input type=\"submit\" value=\"Delete Customer\" />
					</form></td>";
			}
			
			$form.="</td>
				</tr>
				</table>";
			
		
		return $form;
	}
	
	function EmployeeForm($user= '')
	{
		
		$edit= is_array($user);
	
		$file= $edit? 'editEmployee.php': 'insertEmployee.php';
		$username= $edit?$user['username']:'';
		$cat= $edit?$user['category']:'';
		$firstName= $edit?$user['firstName']:'';
		$lastName= $edit?$user['lastName']:'';
		$ssn= $edit?$user['ssn']:'';
		$street= $edit?$user['street']:'';
		$city= $edit?$user['city']:'';
		$state= $edit?$user['st']:'';
		$zip= $edit?$user['zip']:'';
		$email=$edit?$user['email']:'';
		$phone=$edit?$user['phone']:'';
		$paymentamount=$edit?$user['paymentamount']:'';
		$pass=$edit?$user['password']:'';
	
		//if passed an existing item, proceed in edit mode
		$form= "<form method=\"post\"
			action=\"".$file."\">
			<table border=\"0\">
			<tr>
				<td>Username:</td>
				<td><input type=\"text\" name=\"username\" 
				value=\"".$username."\"> </td>
			</tr>
			<tr>
				<td>Account Type:</td>
				<td>
					<select name=\"category\">
					<option value=\"admin\">Administrator</option>
					<option value=\"shipping\">Shipping</option>
					<option value=\"finance\">Finance<option>
					</select>
				</td>
			</tr>
			<tr>
				<td>First Name:</td>
				<td><input type=\"text\" name=\"firstName\"
				value=\"".$firstName."\"> </td>
			</tr>
			<tr>
				<td>Last Name:</td>
				<td><input type=\"text\" name=\"lastName\"
				value=\"".$lastName."\"> </td>
			</tr>
			<tr>
				<td>SSN:</td>
				<td><input type=\"text\" name=\"ssn\"
				value=\"".$ssn."\"> </td>
			</tr>
			<tr>
				<td>Street:</td>
				<td><input type=\"text\" name=\"street\"
				value=\"".$street."\"> </td>
			</tr>
			<tr>
				<td>City:</td>
				<td><input type=\"text\" name=\"city\"
				value=\"".$city."\"> </td>
			</tr>
			<tr>
				<td>State:</td>
				<td><input type=\"text\" name=\"state\"
				value=\"".$state."\"> </td>
			</tr>
			<tr>
				<td>Zip Code:</td>
				<td><input type=\"text\" name=\"zip\"
				value=\"".$zip."\"> </td>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td><input type=\"text\" name=\"email\"
				value=\"".$email."\"> </td>
			</tr>
			<tr>
				<td>Phone:</td>
				<td><input type=\"text\" name=\"phone\"
				value=\"".$phone."\"> </td>
			</tr>
			<tr>
				<td>Payment Amount:</td>
				<td><input type=\"text\" name=\"paymentamount\"
				value=\"".$paymentamount."\"> </td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type=\"text\" name=\"pw\"
				value=\"".$pass."\"> </td>
			</tr>";
			
			
			
			
			if(!$edit)
			{
				$form.="<td colspan=\"2\" align=\"center\">";
			}
			else
			{
				$form.="<td align=\"center\"><input type=\"hidden\" name=\"employeeid\"
				value=".$user['employeeid']." />";
			}
			
			$submission= $edit?'Update':'Add';
			
			$form.="<input type=\"submit\" value=\"".$submission." Employee \"/>
			</form></td>";
			
			if($edit)
			{
				$form.="<td>
					<form method=\"post\" action=\"deleteEmployee.php\">
					<input type=\"hidden\" name=\"employeeid\"
					value=".$user['employeeid']." />
					<input type=\"submit\" value=\"Delete Employee\" />
					</form></td>";
			}
			
			$form.="</td>
				</tr>
				</table>";
			
		
		return $form;
	}
	
	function getEmployee($id)
	{
		$db= dbConnect();
		
		$query= "select * from employees
			where employeeid=".$id."";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		$emp= $result->fetch_assoc();
		
		return $emp;
	}
	
	function getEmployees()
	{
		$db= dbConnect();
		
		if($_SESSION['AccountType']=='admin')
		{
			$destination="\"adminemployee.php\"";
		}
		else if($_SESSION['AccountType']=='finance')
		{
			$destination="\"financeEmployee.php\"";
		}
			
		$query= "select * from employees";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		$employees= "";
		
		while($emp= $result->fetch_assoc())
		{
			$employees.="<table widht=\"40\%\">
			<tr><th>Employee ".$emp['employeeid'].": ".$emp['firstName']." ".$emp['lastName']."</th>
			<td><form action=".$destination."> <input type=\"hidden\" name=\"id\" value=".$emp['employeeid']."><input type=\"submit\" value=\"Edit Employee\"></form></td></tr>
			<tr><th>Username:</th><td>".$emp['username']."</td></tr>
			<tr><th>Account Type:</th><td>".$emp['category']."</td></tr>
			<tr><th>Address:</th><td>".$emp['street']."<br />
						 ".$emp['city'].", ".$emp['st']." ".$emp['zip']."</td></tr>
			<tr><th>Email:</th><td>".$emp['email']."</td></tr>
			<tr><th>Phone:</th><td>".$emp['phone']."</td></tr>
			<tr><th>".$emp['paymenttype']."</th><td>".$emp['paymentamount']."</td></tr>
				     </table> <br />";
		}
		
	return $employees;
	}
	
	function getCustomer($id)
	{
		$db= dbConnect();
		
		$query= "select * from customer
			where customerid=".$id."";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		$c= $result->fetch_assoc();
		
		return $c;
	}
	
	function getCustomers()
	{
		$db= dbConnect();
		
		$query= "select * from customer";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			echo "uable to execute query";
			return false;
		}
		
		$customers= "";
		
		while($c= $result->fetch_assoc())
		{
			$customers.="<table widht=\"40\%\">
			<tr><th>Customer ".$c['customerid'].": ".$c['firstName']." ".$c['lastName']."</th>
			<td><form action=\"admincustomer.php\"> <input type=\"hidden\" name=\"id\" value=".$c['customerid']."><input type=\"submit\" value=\"Edit Customer\"></form></td></tr>
			<tr><th>Username:</th><td>".$c['username']."</td></tr>
			<tr><th>Address:</th><td>".$c['street']."<br />
						 ".$c['city'].", ".$c['st']." ".$c['zip']."</td></tr>
			<tr><th>Email:</th><td>".$c['email']."</td></tr>
			</table> <br />";
		}
		
	return $customers;
	}
?>