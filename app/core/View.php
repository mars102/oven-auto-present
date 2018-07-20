<?php 
namespace app\core;
Class View{
	private $template;
	public function __construct($className)
	{
		$mas = explode('\\', $className);
		$className = array_pop($mas);
		$className = str_replace("Controller","",$className);
		$this->template = lcfirst($className);
	}

	public function render($page,$head,$data=array())
	{
		extract($data);
		$view= TEMPLATE.'/'.$this->template.'/'.$page;
		require_once(TEMPLATE.'/layouts/'.$head);
	}
}