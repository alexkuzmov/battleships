<?php

namespace services\BattleshipsGame;

use services\BattleshipsGame\Ships\Ship;

/**
* Game BoardPoint class
* 
* The BoardPoint specifies the multiple options and states on each point of the board
* 
* @file			BoardPoint.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class BoardPoint {
	
	// Possible contents of the board point
    const POINT_EMPTY = 0;
    const POINT_FULL = 1;
	
	// Possible states of the board point
	const STATE_NO_SHOT = '.';
	const STATE_MISS = '-';
	const STATE_HIT = 'x';
	
	// Current board point state and contents
	private $_contents;
	private $_state;
	
	// Current board point occupant
	private $_occupant = false;
	
	public function __construct()
	{
		// Prepare initial state of the board point
		$this->_contents = self::POINT_EMPTY;
		$this->_state = self::STATE_NO_SHOT;
	}
	
    public function contents($contents = 0)
	{
        if($contents){
            $this->_contents = $contents;
            return $this;
        }

        return $this->_contents;
    }
	
    public function state($state = '')
	{
        if($state){
            $this->_state = $state;
            return $this;
        }

        return $this->_state;
    }
	
    public function occupant(Ship $occupant = null)
	{
        if($occupant){
            $this->_occupant = $occupant;
            return $this;
        }

        return $this->_occupant;
    }
}