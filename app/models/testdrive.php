<?php 
namespace app\models;
Class testdrive extends \app\core\Model
{


	public $table = 'car_6_available';

	public function __construct($data=array())
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
	}

	public static function getCars()
	{
		$cars = new TestDrive();
		$sql = "SELECT * FROM test_drive";
		$cars = $cars->getCustomSQLNonClass($sql);
		
		foreach ($cars as $key => $car) {
			$array['id'] = $car['id'];

			$model = new Car_model();
			$model->getRowById($car['id_car']);
			$array['model'] = $model;

			$complect = new Complect_model();
			$complect->getRowById($car['id_complect']);
			$array['complect'] = $complect;

			$motor = new Motor_model();
			$motor->getRowById($complect->getParam('id_motor'));
			$array['motor'] = $motor;

			$color = new Color_model();
			$color->getRowById($car['color']);
			$array['color'] = $color;

			$data[] = $array;
		}
		return $data;
	}

	public static function getData()
	{
		$models = Car_model::getCarForForm();

		$complects = Complect_model::GetComplectTestDrive();

		$color = Color_model::getColorList();

		return array('models'=>$models,'complects'=>$complects, 'colors'=>$color);
	}

	public static function getTestCar($id)
	{
		$test = new \app\models\car_available();
		
		$sql = "SELECT * FROM {$test->table} WHERE status = 3 AND id_model = ?";
		$res = $test->getCustomSQL($sql,array($id));
		if(!is_array($res)) return false;
		foreach ($res as $key=>$td)
		{
			$model = new \app\models\car_2_model();
			$model->getRowById($td->id_model);
			$res[$key]->model = $model;

			$complect = new \app\models\car_6_complect();
			$complect->getRowById($td->id_complect);
			$res[$key]->complect = $complect;

			$motor = new \app\models\car_3_motor();
			$motor->getRowById($complect->id_motor);
			$res[$key]->motor = $motor;
		}
		return $res;
	}
}