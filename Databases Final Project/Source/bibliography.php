<?php
session_start();

require_once("page.php");


$page= new Page();

$page->content= "<h3>Citations:</h3>
<b>Inspired by:</b> <br />
•	\"Hockey Equipment - Hockey Sticks, Hockey Skates, Ice Hockey Skates, Inline Hockey Skates and More Hockey Gear.\" Hockey Equipment - Hockey Sticks, Hockey Skates, Ice Hockey Skates, Inline Hockey Skates and More Hockey Gear. N.p., n.d. Web 21 Oct. 2012. <www.hockeygiant.com> <br /><br />
•	\"Hockey Equipment & Gear | Hockey Sticks & Skates | Ice Hockey Helmets & Gloves | HockeyMonkey.com.\" Hockey Equipment & Gear | Hockey Sticks & Skates | Ice Hockey Helmets & Gloves | HockeyMonkey.com. N.p., n.d. Web. 21 Oct. 2012.<www.hockeymonkey.com> <br /> <br />
•	\"Total Hockey Stores | Hockey Sticks, Hockey Skates, Apparel & More.\" Total Hockey Stores | Hockey Sticks, Hockey Skates, Apparel & More. N.p., n.d. Web. 15 Dec. 2012. <www.totalhockey.com > <br /> <br />
<br />
Images from: <br />
<b>All hockey equipment images used from:</b> <br />
•	\"Hockey Equipment - Hockey Sticks, Hockey Skates, Ice Hockey Skates, Inline Hockey Skates and More Hockey Gear.\" Hockey Equipment - Hockey Sticks, Hockey Skates, Ice Hockey Skates, Inline Hockey Skates and More Hockey Gear. N.p., n.d. Web 21 Oct. 2012. <www.hockeygiant.com> <br /><br />
<b>Header Image:</b><br />
•	Pond_hockey.jpg. N.d. Photograph. The Fremd High School English Ning. By Russ Anderson. 2012. Web. 2 Dec. 2012. <http://api.ning.com/files/f*OHYOdIjBy3xykmHY7UNkvqxVh1jEAHUnroneJ*3byEq*qI0twXSTIW2YdBFMN3dfvU2yNbmBe7G1uz21yDuXlYsypOosKX/pond_hockey.jpg>. <br /> <br />

<b>Code Citing:</b><br />
•	Welling, Luke, and Laura Thomson. PHP and MySQL Web Development, Fourth Edition. Upper Saddle River [etc.: Addison-Wesley, 2009. Print. <br /><br />
•	\"Storing Objects in Php Session.\" Stackoverflow. N.p., 18 Sept. 2009. Web. 5 Dec. 2012. <http://stackoverflow.com/questions/1442177/storing-objects-in-php-session>.<br /><br />
•	\"PHP Redirect To Another URL  Page Script Redirect  Redirect Web Page.\" Frequently Asked Questions About Linux UNIX RSS. N.p., n.d. Web. 29 Nov. 2012. <http://www.cyberciti.biz/faq/php-redirect/>. <br /><br />
•	\"PHP Manual.\" PHP:. N.p., Nov.-Dec. 2012. Web. Nov.-Dec. 2012. <http://www.php.net/manual/en/>. <br /><br />

";


$page->Display();

?>