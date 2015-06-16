<?php

	session_start();
    require("page.php");
    $contact= new Page();
    
    $contact->content= "<form name=\"myWebForm\" 
                        action=\"mailto:customer_service@hockeyheaven.com\"
                        method=\"post\">
                        <table>
                        <tr>
                        <td class=\"graybg\">
                        Username:
                        </td>
                        <td class= \"graybg\">
                        <input name=\"user\" value=".$_SESSION['valid_user'].">
                        </td>
                        </tr>
                        <tr>
                        <td class=\"graybg\">
                        	Subject:
                        </td>
                        <td class=\"graybg\">
                        	<input name=\"subject\">
                        </td>
                        </tr>
                        </table>
                        Comments<br />
                        <textarea rows=\"10\" cols=\"75\" 
                        name=\"comments\" wrap=\"physical\"></textarea><br/>
                        <input type=\"submit\" value=\"Send\"/>
                        </form>";
    
    $contact->Display();
    
?>
