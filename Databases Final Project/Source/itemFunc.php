<?php
	require_once('dbFunc.php');
	require_once('authFunc.php');
	require_once('item.php');
	
	function calculateShipping()
	{
		return 5.00;
	}
	
	function getCategories()
	{
		$db= dbConnect();
		
		$query= "select catid, catname from categories";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		$num_cats= $result->num_rows;
		
		if($num_cats ==0)
		{
			return false;
		}
		
		
		return $result;
	}
	
	function getCategoryName($catid)
	{
		$db= dbConnect();
		
		$query= "select catname from categories
			where catid= ".$catid."";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		$num_cats= $result->num_rows;
		
		if($num_cats == 0)
		{
			return false;
		}	
		
		$row= $result->fetch_object();
		
		return $row->catname;	
	}
	
	function getItems($catid)
	{
		if((!$catid) || ($catid == ''))
		{
			return false;
		}
		
		$db= dbConnect();
		
		$query= "select * from merchandise 
			where catid= ".$catid."";
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		$numitems= $result->num_rows;
		
		if($numitems == 0)
		{
			return false;
		}
		
		$result= db_result_to_array($result);
		
		return $result;
	}
	
	function getItemDetails($itemid)
	{
		if((!$itemid) || ($itemid ==''))
		{
			return false;
		}
		
		$db= dbConnect();
		
		$query= "select * from merchandise where itemid=".$itemid."";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		$item= $result->fetch_assoc();
		
		return $item;
	}
	
	function getSpecItemDetails($specid, $itemid)
	{
		if((!$itemid) || ($itemid =='') || (!$specid) || ($specid==''))
		{
			return false;
		}
		
		$db= dbConnect();
		
		$query= "select catid from merchandise where itemid=".$itemid."";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return false;
		}
		$item= $result->fetch_assoc();
		
		$cat= getCategoryName($item['catid']);
		
		$query= "select * from ".strtolower($cat)."
			where itemid=".$itemid." and exId=\"".$specid."\"";
		
		$result= $db->query($query);
		
		if(!$result || $result->num_rows == 0)
		{
			return false;
		}
		$row= $result->fetch_assoc();
		
		$special="";
		
		foreach($row as $key=>$value)
		{
                    if($key != 'exId' && $key != 'quantity' && $key != 'itemid')
                        $special.= $value."/";
		}
		
		return $special;
	}
	
	function calculatePrice($cart)
	{
		$price= 0.0;
		
		
		if(is_array($cart))
		{
			$db= dbConnect();
			
			foreach($cart as $itemid =>$qty)
			{
				$item= new Item();
				$item= unserialize($cart[$itemid]);
				
				$query= "select price from merchandise where itemid=".$item->itemid."";
				
				$result= $db->query($query);
				
				if($result)
				{
					$items= $result->fetch_object();
					$itemprice= $items->price;
					$price+=$itemprice*$item->qty;
				}
			}
		}
		
		return $price;
	}
	
	function calculateItems($cart)
	{
		$items= 0;
		
		if(is_array($cart))
		{
			foreach($cart as $itemid => $qty)
			{
				$item= new Item();
				$item= unserialize($cart[$itemid]);
				$items+= $item->qty;
			}
		}
		
		return $items;
	}
	
	function GetRandomItems()
	{
		$db= dbConnect();
		
		$query= "select * from merchandise";
		
		$result= $db->query($query);
		
		if(!$result)
		{
			return "Cannot access database. Please try again later.";
		}
		
		$res= array();
		
		$res= dbResultArray($result);
		
		shuffle($res);
		
		$items="<table>
			<tr>";
		
		for($count=0; $count < 3; $count++)
		{
			$items.= "<td><a style=\"color:#800000\" href=\"itemPage.php?itemid=".$res[$count]['itemid']."\" ><img src= \"Images/".$res[$count]['name'].".jpg\" width=\"180\" height=\"180\"/><br />"
			.$res[$count]['name']."</a>
			<br /> Price: \$".$res[$count]['price']."</td>";
		}
		$items.="</table>
			</tr>";
			
			
		return $items;
		
		
	}
	
	//finds the average review score for an item
	function getReviewScore($id)
	{
		$db= dbConnect();
		
		$query= "select avg(score) as avgScore from reviews
			 where itemid=".$id."";
			 
		$result= $db->query($query);
		
		if(!isset($result)|| $result->num_rows == 0)
		{
			return "No reviews have been written for this item.";
		}
		else
		{
			$row=$result->fetch_assoc();
			return "".$row['avgScore']."/5";
		}
	}
	
	function updateItemStock($itemid, $specid, $inc)
	{
		$db= dbConnect();
		
		$item= getItemDetails($itemid);
		
		$cat= getCategoryName($item['catid']);
		
		$query="update ".strtolower($cat)."
			set quantity=quantity+".$inc."
			where itemid=".$itemid." and exId=\"".$specid."\"";
		
		$result=$db->query($query);
		
		if(!$result)
		{
			return false;
		}
		
		return true;
	}
	
	function CreateExtrasForm($id)
        {
        
            //need to insert results of query
            $row= getItemDetails($id);
            
            $catname= getCategoryName($row['catid']);
            
            $db= dbConnect();
            
            
            $query= "select * from ".strtolower($catname)."
            	     where itemid=".$id."";
            
            $result=$db->query($query);
            if(!$result)
            	return false;
            
            $num_results= $result->num_rows;
            
            $extrasform= "<select name=\"extras\">";
            while($row= $result->fetch_assoc())
            {
            	if($row['quantity'] > 0 || isFinance() || isAdmin() || isShipping())
            	{
                	$extrasform.= "<option value=".$row['exId'].">";
                	foreach($row as $key=>$value)
                	{
                    		if($key != 'exId' && $key != 'quantity' && $key != 'itemid' &&  $value != 'Practice')
                        		$extrasform.= $value." ";
                	}
               $extrasform.="</option>";
        	}
            }
            $extrasform.="</select>";
            
            return $extrasform;
        }



?>