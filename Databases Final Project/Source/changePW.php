<?php
	session_start();
	require_once('authFunc.php');
	require_once('dataValid.php');
	require_once('page.php');
	
	$page= new Page();
	
	
	
	if(!filledOut($_POST))
	{
		$page->content="You have not filled out the form correctly. <br />
			Please try again. <br />".changePWForm()."";
	}
	else
	{
		$newPW= $_GET['newPW'];
		$newPW2= $_GET['newPW2'];
		$oldPW= $_GET['oldPW'];
		$user= $_SESSION['valid_user'];
		$type= $_SESSION['AccountType'];
		
		if($newPW != $newPW2)
		{
			$page->content="Passwords entered are not the same. Password has not been changed. <br />
			".changePWForm()."";
		}
		else if((strlen($newPW)>16) || (strlen($newPW)<6))
		{
			$page->content="New password must be between 6 and 16 characters. Try again. <br />
			".changePWForm()."";
		}
		else
		{
			if(changePW($user, $oldPW, $newPW, $type))
			{
				$page->content="Password changed.";
			}
			else
			{
				$page->content="Password could not be changed. Please try again later.";
			}
		}
	}
	
	$page->Display();

?>