<?php
/**
* Main Controller class
* 
* Used for global functions and parameters for the WEB environment
* 
* @file			Main.controller.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class MainController {
	
	protected $_templatePath = ROOT_PATH . 'web' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
	protected $_templateVariables = [];
	
	public function __construct()
	{
		
	}
	
	// Used to assign variables to templates
	protected function assign($name, $var){
		
		if(!$name || !$var){
			return;
		}
		
		$this->_templateVariables[$name] = $var;
	}
	
	// Used to display a template
	protected function display($templateName = ''){
		
		if(!$templateName){
			return;
		}
		
		// Unpack provided variables
		if(!empty($this->_templateVariables)){
			foreach($this->_templateVariables AS $name => $var){
				$$name = $var;
			}
		}
		
		require $this->_templatePath . $templateName . '.php';
	}
}