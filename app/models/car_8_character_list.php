<?php
namespace app\models;
Class car_8_character_list extends \app\core\Model
{	
	public $table = 'car_8_character_list';


	public function getCharacterByIdModel($id="")
	{
		$result = array();
		$valChar = new car_8_character_value();
		if(empty($id)) return false;
		if(!is_numeric($id)) return false;
		$sql = "SELECT l.id,l.name,o.value 
			FROM {$valChar->table} as o 
			JOIN {$this->table} as l on o.id_character = l.id 
			WHERE o.id_model = ? ";
		$mas = array($id);
		$data = $this->getCustomSQLNonClass($sql,$mas);
		
		foreach ($data as $row)
		{
			$obj = clone($this);
			$objVal = clone($valChar);

			$obj->id = $row['id'];
			$obj->name = $row['name'];
			$objVal->value=$row['value'];
			$obj->value = $objVal;
			$result[] = $obj;
		}
		return $result;
	}
}