<?php

/*
	КЛАСС ДЛЯ ПРЕДСТАВЛЕНИЯ ОПЦИЙ ИЗ БД
*/
namespace app\models;
Class car_5_option_list extends \app\core\Model
{
	public $table = 'car_5_option_list';

	public function getAllComplectFunction($id="")
	{
		if(empty($id)) return false;
		$id = intval($id);
		$sql="	SELECT list.name, list.id FROM $this->table as list
				JOIN car_5_option_value as val
				ON list.id = val.id_option
				WHERE val.id_complect = ?
				ORDER BY list.parent,list.name";
		$mas = array($id);
		//echo $sql." ".$id."<br>";
		$result = $this->getCustomSQL($sql,$mas);
		
		return $result;
	}

	public static function getFilterOption($current="",$str="",$mas=array())
	{
		$data = new \app\models\car_5_option_list();
		$sql = "SELECT * FROM ".$data->table." WHERE filtered<>'0' ORDER BY filter_order";
		$result = $data->getCustomSQL($sql);
		
		$totalC = count($result);
		$i=0;
		foreach ($result as $key => $obj) :
			$i++;
			if($current=="")
			{
				$current = $obj->filtered;
				$name[] = $current;
			}
			
			if($current != $obj->filtered)
			{
				$current = $obj->filtered;
				$mas[] = $str;
				$name[] = $current;
				$str = '';
			}

			if($current == $obj->filtered)
			{
				$str = $obj->filter_order.',';
				$current == $obj->filtered;
			}
			
			if ($i == $totalC) {
		        $mas[] = $str;
		   	}

		endforeach;

		foreach ($name as $key => $opt) {
			foreach ($mas as $index => $value) {
				$value = substr($value, 0,-1);
				if($key==$index) $array[$opt] = $value;
			}
		}
		//Html::prA($array);
		return $array;
	}

	public static function getType()
	{
		$data[]=array('id'=>'1','name'=>'Экстерьер');
		$data[]=array('id'=>'2','name'=>'Комфорт');
		$data[]=array('id'=>'3','name'=>'Безопасность');
		$data[]=array('id'=>'4','name'=>'Коммерческие');
		$data[]=array('id'=>'10','name'=>'Прочее');
		return $data;
	}
	public function getParentName()
	{
		switch ($this->parent) {
			case '1':
				return 'Экстерьер';
				break;
			case '2':
				return 'Комфорт';
				break;
			case '3':
				return 'Безопасность';
				break;
			case '4':
				return 'Коммерческие';
				break;
			case '10':
				return 'Прочее';
				break;
			
			default:
				# code...
				break;
		}
	}

	public static function getParentNameStatic($id='')
	{
		switch ($id) {
			case '1':
				return 'Экстерьер';
				break;
			case '2':
				return 'Комфорт';
				break;
			case '3':
				return 'Безопасность';
				break;
			case '4':
				return 'Коммерческие';
				break;
			case '10':
				return 'Прочее';
				break;
			
			default:
				# code...
				break;
		}
	}
}
