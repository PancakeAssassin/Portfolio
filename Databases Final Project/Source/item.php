<?php

class Item
{
	public $itemid;
	public $specid;
	public $qty;
   
    public function __set($name, $value)
    {
        $this->$name= $value;
    }
    
    
}

?>