<?php 
namespace app\models;
Class ips_visit extends \app\core\Model
{
	public $table = "ips_visit";

	public function getVisitByDate($date)
	{
		$sql = "SELECT * FROM {$this->table} WHERE date = ?";
		$data = $this->getCustomSQLNonClass($sql,array($date))[0];

		if(empty($data['id']))
		{
			$this->date = strtotime(date('d.m.Y'));
			$id= $this->insertData();
			$this->getRowById($id);
		}
		$this->setVariable($data);
	}
}