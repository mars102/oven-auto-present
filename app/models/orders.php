<?php
namespace app\models;
Class orders extends \app\core\Model
{
	public $table = 'orders';

	public $id = 			NULL;
	public $trafic = 		NULL;
	public $client_name = 	NULL;
	public $client_phone = 	NULL;
	public $client_comment = NULL;
	public $client_date = NULL;
	public $test = NULL;
	public $page = NULL;
	public $model = NULL;
	public $complect = NULL;
	public $car = NULL;
	public $color = NULL;
	public $id_pack = NULL;
	public $status = NULL;
	public $date_in = NULL;
	public $part = NULL;
	public $form = NULL;
	public $service = NULL;

	public function getModel()
	{
		$model = new \app\models\car_2_models();
		$this->model = $model->getCustomSQL("SELECT * FROM {$model->table} WHERE id = ?",array($this->model))[0];
	}

	public function getComplect()
	{
		//echo $this->complect;
		$complect = new \app\models\car_6_complect();
		$this->complect = $complect->getCustomSQL("SELECT * FROM {$complect->table} WHERE id = ?",array($this->complect))[0];
		//Html::prA($this->complect);

		$this->complect->model = new \app\models\car_2_model();
		$this->complect->model = $this->complect->model->getCustomSQL("
			SELECT * FROM {$this->complect->model->table} WHERE id = ?",
			array($this->complect->id_model)
		)[0];
		//Html::prA($this->complect->model);

		$this->complect->motor = new \app\models\car_3_motor();
		$this->complect->motor = $this->complect->motor->getCustomSQL("
			SELECT * FROM {$this->complect->motor->table} WHERE id = ?",
			array($this->complect->id_motor)
		)[0];
		//Html::prA($this->complect->motor);
	}

	public function getCar()
	{
		$car = new \app\models\car_available();
		$this->car = $car->getCustomSQL("SELECT * FROM {$car->getParam('table')} WHERE id = ?",array($this->car))[0];
		$this->car->model = new \app\models\car_2_model();
		$this->car->model = $this->car->model->getCustomSQL("SELECT * FROM {$this->car->model->getParam('table')} WHERE id = ?",array($this->car->getParam('id_model')))[0];
		$this->car->complect = new \app\models\car_6_complect();
		$this->car->complect = $this->car->complect->getCustomSQL("SELECT * FROM {$this->car->complect->getParam('table')} WHERE id = ?",array($this->car->getParam('id_complect')))[0];
		$this->car->complect->motor = new  \app\models\car_3_motor();
		$this->car->complect->motor = $this->car->complect->motor->getCustomSQL("SELECT * FROM {$this->car->complect->motor->getParam('table')} WHERE id = ?",array($this->car->complect->getParam('id_motor')))[0];

	}

	public function getTest()
	{
		$car = new \app\models\car_available();
		$this->car = $car->getCustomSQL("SELECT * FROM {$car->getParam('table')} WHERE id = ?",array($this->test))[0];
		$this->car->model = new \app\models\car_2_model();
		$this->car->model = $this->car->model->getCustomSQL("SELECT * FROM {$this->car->model->getParam('table')} WHERE id = ?",array($this->car->getParam('id_model')))[0];
		$this->car->complect = new  \app\models\car_6_complect();
		$this->car->complect = $this->car->complect->getCustomSQL("SELECT * FROM {$this->car->complect->getParam('table')} WHERE id = ?",array($this->car->getParam('id_complect')))[0];
		$this->car->complect->motor = new  \app\models\car_3_motor();
		$this->car->complect->motor = $this->car->complect->motor->getCustomSQL("SELECT * FROM {$this->car->complect->motor->getParam('table')} WHERE id = ?",array($this->car->complect->getParam('id_motor')))[0];

	}

	public function getStatus()
	{
		if($this->status==1)
			return "Не обработан";
		return "Обработан";
	}
}
