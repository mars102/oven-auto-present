<?php

/*
	КЛАСС ДЛЯ ПРЕДСТАВЛЕНИЯ Пакетов опций ИЗ БД
*/
namespace app\models;
Class car_7_pack extends \app\core\Model
{
	public $table = 'car_7_pack';
	public $table_value = 'car_7_pack_value';

	public $option_list = null;
	public $check=NULL;

	public function getPackByAvaCar($param)
	{
		$sql = "SELECT p.id,p.name,p.price,p.code,GROUP_CONCAT(col.name SEPARATOR ' | ') as option_list FROM car_available as ca 
					JOIN car_available_pack as cap 
					ON cap.id_car = ca.id
					JOIN car_7_pack as p 
					ON p.id = cap.id_pack
					JOIN car_7_pack_value as cpv
					ON cpv.id_pack = p.id
					JOIN car_5_option_list as col 
					ON col.id = cpv.id_option
					WHERE ca.id = ?
					GROUP BY p.id
		";
		$mas = array($param);
		$result = $this->getCustomSQL($sql,$mas);
		return $result;
	}

	public function getPackListByComplectId($id)
	{
		$sql = "SELECT p.id,p.name,p.price,GROUP_CONCAT(DISTINCT l.name ORDER BY l.parent ASC SEPARATOR ' | ') AS option_list
						FROM car_7_pack as p
						join car_7_pack_value as v
						on v.id_pack = p.id
						JOIN car_5_option_list as l
						on v.id_option = l.id
						JOIN car_9_pack_complect as compack
						on compack.id_pack = p.id
						WHERE compack.id_complect = ?
						GROUP BY p.id";
		$id = intval($id);
		$mas=array($id);
		$result = $this->getCustomSQL($sql,$mas);
		return $result;
	}
}
