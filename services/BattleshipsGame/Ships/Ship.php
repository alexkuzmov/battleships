<?php

namespace services\BattleshipsGame\Ships;

/**
* Game Ship class
* 
* The Ship class serves as a base for the game ships
* 
* @file			Ship.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class Ship
{
	protected $_length;
	protected $_hitpoints;
	protected $_name;
	
    public function length($length = 0)
	{
        if($length){
            $this->_length = $length;
            return $this;
        }

        return $this->_length;
    }
	
    public function name($name = '')
	{
        if($name){
            $this->_name = $name;
            return $this;
        }

        return $this->_name;
    }
	
    public function hitpoints($hitpoints = -1)
	{
        if($hitpoints > -1){
            $this->_hitpoints = $hitpoints;
            return $this;
        }

        return $this->_hitpoints;
    }
}