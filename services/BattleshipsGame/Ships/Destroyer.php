<?php

namespace services\BattleshipsGame\Ships;

use services\BattleshipsGame\Ships\Ship;

/**
* Game Destroyer Ship class
* 
* The Destroyer ship class is one of the game ships used
* 
* @file			Destroyer.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class Destroyer extends Ship
{
	protected $_length = 4;
	protected $_hitpoints = 4;
	protected $_name = 'Destroyer';
}