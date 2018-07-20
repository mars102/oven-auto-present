<?php 
namespace app\core;

Class Router
{
	private $currentURL;
	private $className = DEFAULT_CLASS;
	private $classMethod = DEFAULT_METHOD;

	public function __construct()
	{
		$this->currentURL = rtrim($_SERVER['REQUEST_URI'], '/');
		$this->currentURL = explode('/', $this->currentURL);
	}

	public function run()
	{
		array_shift($this->currentURL);
		if(isset($this->currentURL[0]))
		{
			$this->className = array_shift($this->currentURL);
		}
		if(isset($this->currentURL[0]))
		{
			$this->classMethod = array_shift($this->currentURL);
		}
		
		$param = $this->currentURL;

		$this->className = 'app\\controllers\\'.ucfirst($this->className).'Controller';
		$this->classMethod = 'action'.ucfirst($this->classMethod);

		if(class_exists($this->className,true))
		{
			if(method_exists($this->className, $this->classMethod))
			{
				$Controller = new $this->className;
				$Method = call_user_func_array(array($Controller, $this->classMethod), $param);
			}
			else {
				$Controller = new \app\controllers\ErrorController;
				$Method = call_user_func_array(array($Controller, "actionIndex"), $param);
			}
		}
		else {
			$Controller = new \app\controllers\ErrorController;
			$Method = call_user_func_array(array($Controller, "actionIndex"), $param);
		}
	}
}