<?php 
namespace app\models;
use \app\core as core;
Class car_2_model extends \app\core\Model
{
	public $table='car_2_model';
	public function __construct($data="")
	{
		parent::__construct($data);
		
		if(!empty($this->id_mark))
		{
			$this->brand = new \app\models\car_1_mark();
			$this->brand->getRowById($this->id_mark);
		}
	}

	
	
	public function getBrand()
	{
		$brand = new \app\models\car_1_mark();
		$brand->getRowById($this->id_mark);
		$this->brand = $brand;
	}

	public function getAllModels($brand="")
	{
		$sql = "SELECT * FROM {$this->table} WHERE id_mark = ?";
		$data = $this->getCustomSQL($sql,array($brand));
		return $data;
	}
	public function getModelByLink($link)
	{
		$sql = "SELECT * FROM {$this->table} WHERE link = ?";
		$array=array($link);
		$data = $this->getCustomSQL($sql,$array)[0];
		return $data;
	}
	public function getDocuments()
	{
		$documents = new \app\models\car_docs();
		$sql = "SELECT * FROM {$documents->table} WHERE link = ?";
		$array=array($this->id);
		$this->documents = $documents->getCustomSQL($sql,$array)[0];
	}
	public function getComplect()
	{
		$complect = new \app\models\car_6_complect();
		$car = new \app\models\car_available();
		$motor = new \app\models\car_3_motor();
		$character = new \app\models\car_8_character_list();
		$option = new \app\models\car_5_option_list();
		$pack = new \app\models\car_7_pack();
		$palette = new \app\models\car_color();

		$sql = "SELECT * FROM {$complect->table} WHERE id_model = ? and status = 1";
		$array = array($this->id);
		$data = $complect->getCustomSQL($sql,$array);
		$this->complect = $data;
		$this->character = $character->getCharacterByIdModel($this->id);
		$this->palette = $palette->getColorListByModelColorId($this->color);
		foreach ($this->complect as $key => $itemComplect)
		{
			$sql = "SELECT * FROM {$car->table} WHERE id_complect = ? AND `status` = 1";
			$array = array($itemComplect->id);
			$data = $car->getCustomSQL($sql,$array);
			$this->complect[$key]->cars = $data;
			
			$sql = "SELECT * FROM {$motor->table} WHERE id = ?";
			$motor->getRowById($itemComplect->id_motor);
			$this->complect[$key]->motor = clone $motor;

			$this->complect[$key]->option = $option->getAllComplectFunction($itemComplect->id);

			$this->complect[$key]->packs = $pack->getPackListByComplectId($itemComplect->id);
		}
	}

	public static function ModelArray($data=array())
	{
		$sql = "SELECT m.id,m.name FROM car_2_model as m WHERE m.id_mark = ?";
		$model = new \app\models\car_2_model();
		$model = $model->getCustomSQLNonClass($sql,array(BRAND));
		foreach ($model as $m)
		{
			$data[$m['id']] = $m['name'];
		}
		return $data;
	}
	public static function ModelLinkArray($data=array())
	{
		$sql = "SELECT m.link,m.name FROM car_2_model as m WHERE m.id_mark = ?";
		$model = new \app\models\car_2_model();
		$model = $model->getCustomSQLNonClass($sql,array(BRAND));
		foreach ($model as $m)
		{
			$data[$m['link']] = $m['name'];
		}
		return $data;
	}

	public static function getOtgruz($country)
	{
		switch ($country) {
			case '1':
				return 'Склад Москва';
				break;
			case '2':
				return 'Склад Тольятти';
				break;
			case '3':
				return 'Порт Санкт-Петербург';
				break;
			case '4':
				return 'Порт Санкт-Петербург';
				break;
			
			default:
				# code...
				break;
		}
	}
	
	


	/* HTML */
	public function getModelForTab()
	{
	?>
		<div class=" col-sm-3 col-lg-3">
	
				<a class="tab-car hidden-xs" href="/content/viewcar/<?= $this->link;?>">
					<img src="http://admin.oven-auto.ru<?= $this->icon; ?>">
					<span class="car-name"><?= $this->name;?></span>
					<!--span class="number-circle" style="font-size: 14px;"><?//=\app\models\car_available::getCountModel($this->id);?></span-->
					<span style="display:block;" class="car-name">
						<small style="text-transform:lowercase !important;">от</small> 
						<?= number_format(\app\models\car_6_complect::minPrice($this->id),0,'',' ');?> 
						<small style="text-transform:lowercase !important;"> руб.</small>
					
					</span>
				</a>

			<?php if(\app\models\car_available::getCountModel($this->id)!=0) : ?>
				<a class="tab-car count-car visible-xs" data-tab-car="<?=$this->id;?>">
					<img src="http://admin.oven-auto.ru<?= $this->icon; ?>">
					<span class="car-name"><?= $this->name;?></span>
					<!--span class="number-circle" style="font-size: 14px;"><?//=\app\models\car_available::getCountModel($this->id);?></span-->
					<span style="display:block;" class="car-name">
						<small style="text-transform:lowercase !important;">от</small> 
						<?= number_format(\app\models\car_6_complect::minPrice($this->id),0,'',' ');?> 
						<small style="text-transform:lowercase !important;"> руб.</small>
						<span class="number-circle-right-model" style="font-size: 14px;">
							<b>
								<?=\app\models\car_available::getCountModel($this->id);?>
							</b>
						</span>
					</span>
				</a>
			<?php else: ?>
				<a class="tab-car visible-xs" href="/content/viewcar/<?= $this->link;?>">
					<img src="http://admin.oven-auto.ru<?= $this->icon; ?>">
					<span class="car-name"><?= $this->name;?></span>
					<!--span class="number-circle" style="font-size: 14px;"><?//=\app\models\car_available::getCountModel($this->id);?></span-->
					<span style="display:block;" class="car-name">
						<small style="text-transform:lowercase !important;">от</small> 
						<?= number_format(\app\models\car_6_complect::minPrice($this->id),0,'',' ');?> 
						<small style="text-transform:lowercase !important;"> руб.</small>
					
					</span>
				</a>

			<?php endif;?>

		
			<?php if(\app\models\car_available::getCountModel($this->id)!=0) : ?>
				<a data-tab-car="<?=$this->id;?>" class="count-car hidden-xs">
					в продаже <?=\app\models\car_available::getCountModel($this->id);?>
					<?=\app\core\Html::getStrCars(\app\models\car_available::getCountModel($this->id));?>
				</a>
			<?php else: ?>
				<a href="/content/viewcar/<?= $this->link;?>" class="count-car hidden-xs">
					о модели
				</a>
			<?php endif;?>
		</div>
		<script>

		</script>
	<?php
	}
}