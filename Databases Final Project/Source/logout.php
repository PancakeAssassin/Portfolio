<?
	session_start();
	require("page.php");
	
	$old_user= $_SESSION['valid_user'];
	unset($_SESSION['valid_user']);
	unset($_SESSION['AccountType']);
	session_destroy();
	
	
	$page= new Page();
	
	$page->content= "<h1>Log Out </h1> <br />";
	
	if(!empty($old_user))
	{
		$page->content.= "Logged out. <br />";
	} 
	else
	{
		$page->content.= "You were not logged in, and so have not been logged out. <br />";
	}
	
	$page->Display();
	
?>