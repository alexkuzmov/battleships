<?php

namespace services\BattleshipsGame;

use services\BattleshipsGame\BoardPoint;
use services\BattleshipsGame\Ships\Ship;

/**
* Game Board class
* 
* The Board class controls the layout and display of the game
* 
* @file			Board.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class Board {
	
	private $_layout = [];
	private $_layoutCopy = [];
	private $_layoutRows = [];
	private $_layoutColumns = [];
	private $_rowAliases = [];
	
	private $_rowCount = 0;
	private $_columnCount = 0;
	
	private $_shipsAdded = 0;
	private $_shotCount = 0;
	
	private $_message = '';
	
	public function __construct($rows, $columns)
	{
		$this->_rowAliases = range('A', 'Z');
		
		// Initialize the board layout
		$this->_rowCount = intval($rows);
		$this->_columnCount = intval($columns);
		
        for ($row = 0; $row < $this->_rowCount; $row++) {
			$this->_layoutRows[] = $this->_rowAliases[$row];
			
            for ($column = 0; $column < $this->_columnCount; $column++) {
				$this->_layoutColumns[] = $column + 1;
				
                $this->_layout[$row][$column] = new BoardPoint();
            }
        }
	}
	
    public function message($message = '')
	{
        if($message){
            $this->_message = $message;
            return $this;
        }

        return $this->_message;
    }
	
    public function layout($layout = null)
	{
        if($layout){
            $this->_layout = $layout;
            return $this;
        }

        return $this->_layout;
    }
	
    public function layoutRows($layoutRows = null)
	{
        if($layoutRows){
            $this->_layoutRows = $layoutRows;
            return $this;
        }

        return $this->_layoutRows;
    }
	
    public function layoutColumns($layoutColumns = null)
	{
        if($layoutColumns){
            $this->_layoutColumns = $layoutColumns;
            return $this;
        }

        return $this->_layoutColumns;
    }
	
	private function copyLayout(){
		$this->_layoutCopy = [];
		
		foreach($this->_layout AS $rowKey => $row){
			$this->_layoutCopy[$rowKey] = [];
			
			foreach($row AS $columnKey => $column){
				$this->_layoutCopy[$rowKey][$columnKey] = clone $column;
			}
		}
	}
	
	private function restoreLayout(){
		$this->_layout = [];
		
		foreach($this->_layoutCopy AS $rowKey => $row){
			$this->_layout[$rowKey] = [];
			
			foreach($row AS $columnKey => $column){
				$this->_layout[$rowKey][$columnKey] = clone $column;
			}
		}
	}
	
	public function addShip(Ship $ship)
	{
		$this->_shipsAdded++;
		
		do {
			$placement = $this->randomizePlacement();
			
			$placed = $this->attemptToPlaceShip($ship, $placement);
		} while (!$placed);
	}
	
	protected function randomizePlacement()
	{
		// Orientation of the ship
		$orientation = ['vertical', 'horizontal'];
		$randomOrientation = $orientation[rand(0, 1)];
		
		// Direction of the ship
		$direction = ['vertical' => ['up', 'down'], 'horizontal' => ['left', 'right']];
		
        return [
            'orientation' => $randomOrientation,
            'direction' => $direction[$randomOrientation][rand(0, 1)],
            'row' => rand(0, $this->_rowCount - 1),
            'column' => rand(0, $this->_columnCount - 1),
        ];
	}
	
    protected function attemptToPlaceShip(Ship $ship, $placement)
    {
		$shipLength = $ship->length();
		
		// Save original layout
		$this->copyLayout();
		
		for ($i = 0; $i < $shipLength; $i++) {
			
			if(
				// If we are out of bounds then the ship cannot be placed
				!isset($this->_layout[$placement['row']])
				|| (isset($this->_layout[$placement['row']]) && !isset($this->_layout[$placement['row']][$placement['column']]))
				
				// If even one place is occupied then we cant place the ship
				|| $this->_layout[$placement['row']][$placement['column']]->contents()
			){
				$this->restoreLayout();
				
				return false;
			}
			
			// If the current point is free, we can set it
			$this->_layout[$placement['row']][$placement['column']]->contents(BoardPoint::POINT_FULL);
			$this->_layout[$placement['row']][$placement['column']]->occupant($ship);
			
			// Move onto next one
			switch($placement['orientation']){
				case 'vertical':
					switch($placement['direction']){
						case 'up':
							$placement['row']--;
						break;
						
						case 'down':
							$placement['row']++;
						break;
					}
				break;
				
				case 'horizontal':
				
					switch($placement['direction']){
						case 'left':
							$placement['column']--;
						break;
						
						case 'right':
							$placement['column']++;
						break;
					}
				break;
			}
		}
		
		// In case the cycle finished, we can be sure that the ship has been placed
		return true;
    }
	
	public function recordShot($coordinate){
		
		// The coordinate should have minimum of 2 length
		if(strlen($coordinate) < 2){
			return false;
		}
		
		$coordinate = strtoupper($coordinate);
		
		$rowCoordinate = preg_replace('/[^A-Z]+/', '', $coordinate);
		$columnCoordinate = preg_replace('/[^0-9]+/', '', $coordinate);
		
		// Determine where the shot landed
		$row = array_search($rowCoordinate, $this->_rowAliases);
		$column = intval($columnCoordinate) - 1;
		
		if(
			// If we are out of bounds then the ship cannot be found
			!isset($this->_layout[$row])
			|| (isset($this->_layout[$row]) && !isset($this->_layout[$row][$column]))
		){
			$this->_message = 'Out of Board bounds.';
			
			return false;
		}
		
		// Record the shot
		if($this->_shipsAdded > 0){
			$this->_shotCount = $this->_shotCount + 1;
		}
		
		// Check for a ship
		$ship = $this->_layout[$row][$column]->occupant();
		
		// If a ship was found we can do further checks for validity
		if($ship){
			
			// Check the current hitpoints
			$shipHitpoints = $ship->hitpoints();
			
			// Check the current state of the board point
			$currentState = $this->_layout[$row][$column]->state();
			
			switch($currentState){
				
				// This means that the player shot twice or more in the same place
				case BoardPoint::STATE_HIT:
				
					// Handle dual shots
					$this->_message = 'Stop shooting the same place!';
				break;
				
				case BoardPoint::STATE_NO_SHOT:
				
					$ship->hitpoints($shipHitpoints - 1);
					$this->_layout[$row][$column]->state(BoardPoint::STATE_HIT);
					
					$this->_message = 'Hit!';
					
					// Check if the ship has sunk
					if($ship->hitpoints() == 0){
						
						$this->_message = $ship->name() . ' Sunk';
						
						// Remove one ship from the count
						$this->_shipsAdded = $this->_shipsAdded - 1;
					}
				break;
			}
		}else{
			
			// If there is nothing on the board, we can set the field for a missed shot
			$this->_layout[$row][$column]->state(BoardPoint::STATE_MISS);
			
			$this->_message = 'Miss';
		}
		
		if($this->_shipsAdded == 0){
			$this->_message = 'Well done! You completed the game in ' . $this->_shotCount . ' shots.';
		}
		
		return true;
	}
}