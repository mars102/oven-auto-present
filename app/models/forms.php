<?php 
namespace app\models;
Class forms extends \app\core\Model
{
	public $table = 'forms';
	/*public function __construct($data=array())
	{
		foreach ($data as $d_key => $d_val)
		{
			foreach ($this as $t_opt => $t_default)
			{
				if($d_key == $t_opt)
				{
					$this->$t_opt = $d_val;
				}
			}
		}
		parent::__construct();
	}*/

	protected function makeForm($pic="")
	{
		$img="";
		if(!empty($pic)) $img = "
							
							<div class='text-center'><img src='/images/form/".$this->picture."'></div>
							";

		return "{$img} <form action='/ajax/formsend' method='POST' class='form-list client-form' id='fcb".$this->id."'>
				<span class='form-head'>".$this->header."</span>
				<input type='hidden'  value='".$this->id."' name='id'>
				";
	}
	protected function closeForm()
	{
		$type = "<input type='hidden' value='{$this->type}' name='type'>";
		return "{$type} </form>";
	}
	
	public static function getFormList()
	{
		$sql = "SELECT id,title FROM forms ";
		$form = new \app\models\forms();
		$form = $form->getCustomSQL($sql);
		return $form;
	}

	public function getFormById($id='',$pic="")
	{
		if(empty($id)) return false;
		if($this->getRowById($id))
		{
			if(strpos($this->html, '.txt'))
				if(strpos($this->html,'project'))
					$form = include (ROOT.$this->html);
				else
					$form = include(ROOT.'/forms/'.$this->html);
			else
				$form = $this->html;
			$form = $this->makeForm($pic).$form.$this->closeForm();
			return $form;
		}
	}

	public function getFormsData($data=array(),$pic="",$str="")
	{
		if(empty($data)) :
			$str = "";
		else :
			foreach ($data as $key => $value) :
				$str .= '?,';
			endforeach;
			$str = substr($str, 0,-1);
			$str = "WHERE id IN (".$str.")";
		endif;
		$sql = "SELECT * FROM $this->table $str ";
		
		$mas = $this->getCustomSQL($sql,$data);
		foreach ($mas as $key => $form) {
			$form->html = $form->getFormById($form->id,$pic);
		}
		return $mas;
	}
}