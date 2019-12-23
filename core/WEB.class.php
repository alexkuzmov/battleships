<?php
/**
* WEB class 
* 
* Control class for web controllers
* 
* @file			WEB.class.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class WEB {
	protected $_loader = null;
	protected $_urlInfo = null;
	
	protected $_defaultController = 'Index';
	protected $_defaultAction = 'index';
	
	protected $_executeController = '';
	protected $_executeAction = '';
	
    public function __construct($_url)
	{
		// Prepare URL info
		$this->_urlInfo = parse_url($_url);
		
		// Isolate routing params
		$path = explode('/', ltrim($this->_urlInfo['path'], '/'));
		
		$this->_executeController = (isset($path[0]) && strlen($path[0]) > 0 ? ucfirst($path[0]) : $this->_defaultController);
		$this->_executeAction = (isset($path[1]) && strlen($path[1]) > 0 ? $path[1] : $this->_defaultAction);
    }
	
    public function load($loader = null)
	{
        if($loader){
            $this->_loader = $loader;
            return $this;
        }

        return $this->_loader;
    }
	
    public function respond()
	{
		// Always load Main controller
		$this->load()->controller('Main');
		
		// Load found controller
		$this->load()->controller($this->_executeController);
		
		// Get controller class name
		$controllerClass = $this->_executeController . 'Controller';
		$actionName = $this->_executeAction . 'Action';
		
		$controller = new $controllerClass();
		$controller->$actionName();
    }
}