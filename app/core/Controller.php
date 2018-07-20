<?php 
namespace app\core;
Class Controller
{
	protected $view;
	private $className;
	public function __construct()
	{
		$this->className = get_called_class();
		$this->view = new \app\core\View($this->className);
	}
}