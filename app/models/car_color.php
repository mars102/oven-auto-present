<?php
namespace app\models;
Class car_color extends \app\core\Model
{
	public $table = 'car_color';

	/*Вернёт массив объектов колор через параметр=поле цвет в объекте модель*/
	public function getColorListByModelColorId($param)
	{
		$param = explode(',',$param);
		foreach ($param as $value)
		{
			$mas[]=$value;
			$str[]='?';
		}
		$str=implode(',',$str);
		$sql = "SELECT * FROM $this->table WHERE id IN ({$str})";
		$result = $this->getCustomSQL($sql,$mas);
		return $result;
	}

	/*Вернёт массив объектов колор через параметр=поле цвет в объекте модель*/
	public function getColorListByComplect($complect)
	{
		$str = array();
		$colcom = new \app\models\color_complect();

		$colcom = $colcom->getCustomSQL("SELECT * FROM {$colcom->table} WHERE id_complect = ?",array($complect));

		foreach ($colcom as $key => $value) {
			$str[] = $value->color; 
		}
		$str = implode(',',$str);

		$sql = "SELECT * FROM $this->table WHERE id IN ({$str})";
		$result = $this->getCustomSQL($sql);
		return $result;
	}

	public static function getColorList()
	{
		$color = new \app\models\car_color();
		$color = $color->getAll();
		return $color;
	}
}
