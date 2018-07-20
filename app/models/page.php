<?php
namespace app\models;
class page extends \app\core\Model
{
	public $table = "pages";
	public function getStatus($id)
	{
		if($id==0) return "Не активно";
		if($id==1) return "Активно";
	}

	public static function getStatusList()
	{
		return array('0'=>'Не показывать','1'=>'Показывать');
	}

	public static function getMenus()
	{
		$brand = BRAND;
		$page = new \app\models\page();
		$sql = "SELECT id,name FROM menu WHERE brand = {$brand} order by sort" ;
		$data = $page->getCustomSQLNonClass($sql);
		foreach($data as $key => $row)
		{
			$sql = "SELECT id,link,title FROM {$page->table} WHERE id_menu = {$row['id']} AND status = 1 order by id";
			$data[$key]['pages'] = $page->getCustomSQL($sql);
		}
		return $data;
	}

	
}