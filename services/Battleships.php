<?php

namespace services;

use services\BattleshipsGame\Board;
use services\BattleshipsGame\Ships\Destroyer;
use services\BattleshipsGame\Ships\Battleship;

/**
* Battleships class
* 
* Main game controller class
* 
* @file			Battleships.service.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class Battleships {
	
	private $_board;
	
	public function __construct()
	{
		$this->_board = new Board(10, 10);
		
		// Add some ships to the board
		$destroyer1 = new Destroyer();
		$destroyer2 = new Destroyer();
		$battleship = new Battleship();
		
		// Add 2 Destroyers
		$this->_board->addShip($destroyer1);
		$this->_board->addShip($destroyer2);
		
		// Add 1 Battleship
		$this->_board->addShip($battleship);
	}
	
    public function board(Board $board = null)
	{
        if($board){
            $this->_board = $board;
            return $this;
        }

        return $this->_board;
    }
}