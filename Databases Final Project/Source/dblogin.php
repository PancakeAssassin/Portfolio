<?
	session_start();
	require_once("page.php");
	require_once("authFunc.php");
	
	$page= new Page();
	
		$username= $_POST["username"];
		$pwd= $_POST["pwd"];
		$accountType= $_POST["accountType"];
		
		
		$_SESSION['valid_user'];
		$_SESSION['AccountType'];
		
		if(!$username || !$pwd)
		{
			$page->content= loginform();
		}
		
   	 	
		
		
		if(login($username, $pwd, $accountType))
		{
			$_SESSION['valid_user']= $username;
			$_SESSION['AccountType']= $accountType;
			
			$page->content= "Login Successful! Welcome, ".$username.".";
			
		}
		else
		{
			//if not match is found tell user they were not logged in
			$page->content= "Invalid username/password combination. Please try again.".loginform()."
					<br />".$username." not found.";
			
		}


	$page->Display();
?>