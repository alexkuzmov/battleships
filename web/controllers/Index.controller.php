<?php

use services\Battleships;

/**
* Index Controller class
* 
* Controll class for the home page
* 
* @file			Index.controller.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class IndexController extends MainController {
	
	public function __construct()
	{
		
	}
	
	public function indexAction()
	{
		$game = new Battleships();
		
		// Record the game board
        if (!isset($_SESSION['board'])) {
			$_SESSION['board'] = $game->board();
        } else {
			// Restore the game board
			$game->board($_SESSION['board']);
        }
		
		// Check data integrity
		if(isset($_POST['shot']) && strlen($_POST['shot']) > 0){
			// Record shot
			$game->board()->recordShot($_POST['shot']);
			
			$this->assign('message', $game->board()->message());
		}
		
		$this->assign('layout', $game->board()->layout());
		$this->assign('layoutRows', $game->board()->layoutRows());
		$this->assign('layoutColumns', $game->board()->layoutColumns());
		$this->display('index');
	}
	
	public function newAction()
	{
        session_destroy();
        header('Location: /');
	}
}