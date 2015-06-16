<?php

session_start();
require_once("page.php");
require_once("itemFunc.php");


$homepage= new Page();


$homepage->content= "<p>Welcome to Hockey Heaven.</p> 
                     <br/>";
                     
$homepage->content.="<h4>Check out some of these items</h4>".GetRandomItems()."";

$homepage->Display();
?>
