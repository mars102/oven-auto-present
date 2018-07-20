<?php
namespace app\models;
Class car_3_motor extends \app\core\Model
{	
	public $table = 'car_3_motor';

	public function __construct()
	{
		parent::__construct();
		if(!empty($this->type))
		{
			$this->fuel = new \app\models\car_4_mtype();
			$this->fuel->getRowById($this->type);
		}
	}

	public function getMotorById($id)
	{
		$this->getRowById($id);
		$this->setFuel();
		return $this;
	}

	public function setFuel()
	{
		$this->fuel = new \app\models\car_4_mtype();
		$this->fuel->getRowById($this->type);
	}
	
	public function getTypeMotor()
	{
		$table_motor_type = $this->table_motor_type;
		$sql = "SELECT id as type_id, name as type_name  FROM $table_motor_type ";
		$result = $this->getCustomSQL($sql);
		return $result;
	}

	public static function getTypeForMotor($id="")
	{
		$motor = new \app\models\car_3_motor();
		$sql = "SELECT id as type_id, name as type_name  FROM car_4_mtype WHERE id = $id ";
		$result = $motor->getCustomSQLNonClass($sql);
		return $result[0]['type_name'];
	}

	public function getMotorList()
	{
		$table_motor_list = $this->table;
		$table_motor_type = $this->table_motor_type;
		$sql = "SELECT l.id,l.type,l.size,l.valve,l.power,l.transmission,l.privod, t.name as type_name 
				FROM $table_motor_list as l 
				JOIN $table_motor_type as t 
				on t.id = l.type";
		$result = $this->getCustomSQL($sql);
		return $result;
	}

	public function getFullMotorName($privod="")
	{
		return $this->type_name.' '.$this->size.' '.$this->power.'л.с. '.$this->valve.'кл. '.$this->transmission.' '.$this->privod;
	}

	public function getMotorNameAdmin($privod="")
	{
		return $this->size.' ('.$this->power.'л.с.) '.$this->transmission.' '.$this->privod;
	}

	public function getMotorForUser($type="", $privod="")
	{	

		if($type=='1') $privod="";
		else $privod = $this->privod;
		$this->setFuel();
		$kpp = $this->transmission;
		if($this->transmission!="CVT")
			$kpp = mb_substr($this->transmission,0,-1);
		return $this->size.' ('.$this->power.'л.с.) '.$kpp.' '.$privod;
	}

	public function getHeaderMotorName()
	{
		if($this->privod=='2WD') $privod="";
		else $privod = $this->privod;
		return $this->type_name.' '.$this->size.' '.$this->power.'л.с. '.$this->valve.'кл. '.$this->transmission.' '.$privod;
	}


	public static function getTransmission()
	{
		$motor = new \app\models\car_3_motor();
		$sql = "SELECT transmission FROM car_3_motor GROUP BY transmission";
		$motor=$motor->getCustomSQLNonClass($sql);
		return $motor;
	}
	public static function getTransmissionList()
	{
		return array('МКП5','МКП6', 'CVT','АКП4', 'АКП5', 'АКП6', );
	}
	public static function getPrivod()
	{
		$motor = new \app\models\car_3_motor();
		$sql = "SELECT privod FROM car_3_motor GROUP BY privod";
		$motor=$motor->getCustomSQLNonClass($sql);
		return $motor;
	}
	public static function getPrivodForFilter()
	{
		$privod = \app\models\car_3_motor::getPrivod();
		foreach ($privod as $key => $value) {
			if($value['privod']!='AWD' && $value['privod']!='4WD')
			{
				$motor = new \app\models\car_3_motor();
				$motor->privod=$value['privod'];
				$data[] = array('type' => $value['privod'], 'summary' => $motor->getSummaryPrivod($value['privod']));
			}
			else $data[] = array('type' => '4WD,AWD', 'summary' => 'Полный');
		}
		return $data;
	}
	public static function getPrivodList()
	{
		return array('FWD','RWD','4WD','AWD');
	}

	public function getSummaryPrivod()
	{
		switch ($this->privod) {
			case 'FWD':
				return 'Передний';
				break;
			case '4WD':
				return 'Подключаемы полный';
				break;
			case 'AWD':
				return 'Постоянный полный';
				break;
			case 'RWD':
				return 'Задний';
				break;
			
			default:
				# code...
				break;
		}
	}

	/*public static function getSummaryPrivod($id)
	{
		switch ($id) {
			case 'FWD':
				return 'передний привод';
				break;
			case '4WD':
				return 'подключаемы полный привод';
				break;
			case 'AWD':
				return 'постоянный полный привод';
				break;
			case 'RWD':
				return 'задний привод';
				break;
			
			default:
				# code...
				break;
		}
	}*/

	public static function getTransmissionForFilter($mech='',$auto='')
	{
		$transmission = \app\models\car_3_motor::getTransmission();
		foreach ($transmission as $key => $value) {
			if(stripos($value['transmission'], "М")!==false) $mech .= $value['transmission'].",";
			else $auto .= $value['transmission'].',';
		}
		$data[] = array('type'=>'Механическая','params'=>substr($mech,0,-1));
		$data[] = array('type'=>'Автоматическая','params'=>substr($auto,0,-1));
		return $data;
	}

	public static function getTransmissionName($trans="")
	{
		switch ($trans) {
			case 'МКП5':
				return 'Механическая, пятиступенчатая';
				break;
			case 'МКП6':
				return 'Механическая, шестиступенчатая';
				break;
			case 'АКП4':
				return 'Автоматическая, четырёхступенчатая';
				break;
			case 'АКП5':
				return 'Автоматическая, пятиступенчатая';
				break;
			case 'АКП6':
				return 'Автоматическая, шестиступенчатая';
				break;
			case 'CVT':
				return 'Автоматическая, бесступенчатая';
				break;
			
			default:
				# code...
				break;
		}
	}


}