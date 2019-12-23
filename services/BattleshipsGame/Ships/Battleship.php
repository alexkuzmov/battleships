<?php

namespace services\BattleshipsGame\Ships;

use services\BattleshipsGame\Ships\Ship;

/**
* Game Battleship Ship class
* 
* The Battleship ship class is one of the game ships used
* 
* @file			Battleship.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class Battleship extends Ship
{
	protected $_length = 5;
	protected $_hitpoints = 5;
	protected $_name = 'Battleship';
}