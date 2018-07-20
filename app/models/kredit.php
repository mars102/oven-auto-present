<?php
namespace app\models;
Class kredit extends \app\core\Model
{
	public $table = 'kredit';
	/*public function __construct($data=array())
	{	
		//parent::__construct();
		
		/*foreach ($data as $d_key => $d_val)
		{
			foreach ($this as $t_opt => $t_default)
			{
				if($d_key == $t_opt)
				{
					$this->$t_opt = $d_val;
				}
			}
		}*/

		/*if(isset($this->id)) {
			$sql = "SELECT id_model FROM kredit_car WHERE id_kredit = {$this->id} ";
			$cars = $this->getCustomSQLNonClass($sql);
			$this->usecar = $cars;
		}
		if(empty($this->banner))
			$this->banner = '/images/kredit.jpg';*/
		
	/*}*/
	public function insertUseCar()
	{
		foreach($this->usecar as $car) 
		{
			$sql = "INSERT into kredit_car (id_kredit,id_model) VALUES (?,?) ";
			$result = $this->db->prepare($sql);
			$result->bindValue(1,$this->id,PDO::PARAM_INT);
			$result->bindValue(2,$car,PDO::PARAM_INT);
			$result->execute();
		}
	}
	public function setUseCar()
	{
		$sql = "SELECT id_model FROM kredit_car WHERE id_kredit = {$this->id} ";
		$cars = $this->getCustomSQLNonClass($sql);
		$this->usecar = $cars;
	}

	public function getKreditByIdCar($id)
	{
		$sql = "SELECT k.id,k.day_in,k.day_out,k.contribution,k.rate,k.pay,k.period,k.disklamer,k.name,k.banner,k.dopoption 
				FROM kredit as k join kredit_car as c on c.id_kredit = k.id WHERE c.id_model = ? GROUP bY k.id";
		$mas = array($id);
		$data = $this->getCustomSQL($sql,$mas);
		return $data;
	}

	public function getActualKreditList()
	{
		$model = new \app\models\car_2_model();
		$sql = "SELECT * FROM `kredit` /*WHERE FROM_UNIXTIME(day_in)<=CURRENT_DATE() AND FROM_UNIXTIME(day_out)>=CURRENT_DATE()*/";
		$data = $this->getCustomSQL($sql);
		foreach ($data as $key => $kredit) {
			$sql = "SELECT GROUP_CONCAT(id_model) as model FROM kredit_car WHERE id_kredit = {$kredit->id}  ORDER BY id_model";
			$cars = $kredit->getCustomSqlNonClass($sql)[0]['model']; 
			$sql = "SELECT * FROM {$model->table} WHERE id in ({$cars}) ";
			$kredit->model = $model->getCustomSQL($sql);
		}
		return $data;
	}


	/**************HTML*************************/


}