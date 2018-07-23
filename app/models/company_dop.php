<?php 
namespace app\models;
Class company_dop extends \app\core\Model
{
	public $table = "company_dop";

	public function getDopById($id)
	{
		$mas = array();
		$sql = "SELECT id_dop FROM {$this->table} WHERE id_company = ? ";
		$data = $this->getCustomSQLNonClass($sql,array($id));
		if(is_array($data))
		{
			foreach ($data as $key => $value) {
				$mas[] = $value['id_dop'];
			}
		}
		return $mas;
	}

	public static function getDopByIdSynonim($id)
	{
		$obj = new \app\models\company_dop();
		$data = $obj->getDopById($id);
		return $data;
	}
}