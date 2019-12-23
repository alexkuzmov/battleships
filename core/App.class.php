<?php
/**
* App class 
* 
* Central class of the system
* 
* @file			App.class.php
* @author		Alex Kuzmov <alexkuzmov@gmail.com>
*   	
*/
class App {
	
	// App Class properties
	protected $url = null;
	
	public function __construct()
	{
		// Make custom URL each time
		$this->url = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '' . $_SERVER['REQUEST_URI'];
		
        if($this->url == '' || !filter_var($this->url, FILTER_VALIDATE_URL)){
			
			header("HTTP/1.1 400 URL is invalid.");
			
            return;
        }
	}
	
	public function loader($loader = null)
	{
		if($loader){
			$this->_loader = $loader;
		}
		
		return $this->_loader;
	}
	
	public function run()
	{
		$this->_loader->env('web')->core('WEB');
		
		// Setup enviroment
		$web = new WEB($this->url);
		$web->load($this->_loader)->respond();
	}
}