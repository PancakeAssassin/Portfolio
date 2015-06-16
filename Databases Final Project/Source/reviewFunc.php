<?php
	
	require_once('dbFunc.php');
	require_once('itemFunc.php');
	
	function ReviewForm($id, $rev= '')
	{
	
		$edit= is_array($rev);
		
		$db= dbConnect();
		
		$item= getItemDetails($id);
		
		
		$form="<h3>Review for ".$item['name']."";
		
		$submitTo=$edit? 'editReview.php':'insertReview.php';
		$blurb=$edit?$rev['blurb']:'';
		$score= $edit?$rev['score']:'';
		//if passed an existing item, proceed in edit mode
		$form.= "<form method=\"post\"
			action=\"".$submitTo."\">
			<table border=\"0\">
			<tr>
			<td>
			<img src=\"Images/".$item['name'].".jpg\" height=\"100\" width=\"100\"/>
			</td>
			<td>
			<b>Score:</b>
			<select name=\"score\">
				<option value=\"0\">0</option>
				<option value=\"1\">1</option>
				<option value=\"2\">2</option>
				<option value=\"3\">3</option>
				<option value=\"4\">4</option>
				<option value=\"5\">5</option>
			</select>
			</td>
			</tr>
			<tr>
				<td><b>Review:</b></td>
				<td><textarea rows=\"20\" cols=\"45\" name= \"blurb\" value=\"blurb\">".$blurb."</textarea></td>
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
			
			
			$submission= $edit? 'Update': 'Submit';
			
			$form.="<input type=\"hidden\" name=\"itemid\" value=\"".$id."\">
			<input type=\"submit\" value=\"".$submission." Review \"/>
			</form></td>";
			
			if($edit)
			{
				$form.="<td>
					<form method=\"post\" action=\"deleteReview.php\">
					<input type=\"hidden\" name=\"itemid\"
					value=\"".$id."\" />
					<input type=\"submit\" value=\"Delete Review\" />
					</form></td>";
			}
			
			$form.="</td>
				</tr>
				</table>";
			
		
		return $form;
	}
	
	function submitReview($item, $user, $score, $blurb)
	{
		$db= dbConnect();
		
		$query= "insert into reviews 
			values (".$item.",".$user.",".$score.",\"".$blurb."\")";
			
		$result= $db->query($query);
		
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	
	
	}
	
	function getReviews($item)
	{
		$db= dbConnect();
		
		$query= "select *
			from reviews
			where itemid=".$item."";
			
		$result= $db->query($query);
		
		if(!$result || $result->num_rows == 0)
		{
			return "There are no reviews for this item.";
		}
		
		$reviews= "";
		
		while($row= $result->fetch_assoc())
		{
			$query= "select username from customer
			where customerid=".$row['customerid'].""; 
			
			$result2= $db->query($query);
			
			$customer= $result2->fetch_assoc();
						
			$reviews.="<table width=\"40\%\">
			<tr><th>Review by:</th> <td>".$customer['username']."</td></tr>
			<tr><th>Score:</th><td>".$row['score']."/5</td></tr>
			<tr><th>Review:</th><td>".$row['blurb']."</td></tr>
			</table>";
		}
		
		return $reviews;
	}

?>