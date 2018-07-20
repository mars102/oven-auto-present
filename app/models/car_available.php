<?php
namespace app\models;
Class car_available extends \app\core\Model
{
    public $table = "car_available";

	public function getAvaCar($id)
	{		
		$sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
		$res = $this->getCustomSQL($sql,array($id));
		foreach ($res as $key=>$td)
		{
			$model = new \app\models\car_2_model();
			$brand = new \app\models\car_1_mark();
			$model->getRowById($td->id_model);
			$brand->getRowById($model->id_mark);
			$model->brand = $brand;
			$res[$key]->model = $model;

			$complect = new \app\models\car_6_complect();
			$complect->getRowById($td->id_complect);
			$res[$key]->complect = $complect;

			$option = new \app\models\car_5_option_list();
			$res[$key]->complect->option = $option->getAllComplectFunction($complect->id);

			$packs = new \app\models\car_7_pack();
			$res[$key]->packs = $packs->getPackByAvaCar($td->id);

			$motor = new \app\models\car_3_motor();
			$motor->getRowById($complect->id_motor);
			$motor->setFuel();
			$res[$key]->motor = $motor;
		}
		return $res[0];
	}

    public static function getCountModel($model)
    {
        $car = new \app\models\car_available();
        $sql = "SELECT count(id) as count FROM {$car->table} WHERE id_model = ? and `status` <> 3 AND `status`<>2";
        $data = $car->getCustomSQLNonClass($sql,array($model))[0];
        return $data['count'];
    }

    public static function getCountComplect($complect)
    {
        $car = new \app\models\car_available();
        $sql = "SELECT count(id) as count FROM {$car->table} WHERE id_complect = ? AND `status` = 1";
        $data = $car->getCustomSQLNonClass($sql,array($complect))[0];
        return $data['count'];
	}
	
	public function getCarPrice()
	{
		$sql = "SELECT * FROM carprice WHERE id = ?";
		$array = array($this->id);
		$data = $this->getCustomSQLNonClass($sql,$array)[0];
		return ($data['complectprice']+$data['packprice']+$data['dopprice']);
	}
	public function getPackPrice()
	{
		$sql = "SELECT * FROM carprice WHERE id = ?";
		$array = array($this->id);
		$data = $this->getCustomSQLNonClass($sql,$array)[0];
		return ($data['packprice']);
	}

	public function getLocationById($id="",$date="")
	{
		switch ($id) {
			case '1':
				$res = 'А/м в наличии';
				break;
			case '2':
				$res = 'Готов к отгрузке';
				break;
			case '3':
				if(!empty($date))
					$res = 'Сборка '.$date;
				else
					$res = 'А/м в производстве';
				break;
			default:
				$res = 'Узнайте у менеджера';
				break;
		}
		return $res;
	}

	public function getLocation()
	{
		switch ($this->location) {
			case '1':
				$res = 'А/м в наличии';
				break;
			case '2':
				$res = 'А/м готов к отгрузке';
				break;
			case '3':
				if(!empty($this->adding))
					$res = 'Сборка '.$this->adding;
				else
					$res = 'А/м в производстве';
				break;
			default:
				$res = 'Узнайте у менеджера';
				break;
		}
		return $res;
	}

	public function getColorCar()
	{
		$color = new \app\models\car_color();
		$color->getRowById($this->color);
		return $color;
	}

	public static function getLocationList()
	{
		$mas[1] = 'На складе';
		$mas[2] = 'Готов к отгрузке';
		$mas[3] = 'В производстве';
		return $mas;
	}
	
	public function getAvaListCar($page,$amount,$filter=array())
	{
		$str = '';
		$mas=array();
		$trans = array();
		$transmas=array();
		$privod=array();
		$privodmas=array();

		if($filter['model']) 
		{
			$str.=" model.id = ? AND"; 
			$mas[] = $filter['model'];
		}
		if($filter['transmission']) 
		{
			$trans = explode(',',$_POST['transmission']);
			foreach($trans as $val) 
			{
				$transmas[] = "?";
				$mas[] = $val;
			}
			$trans = implode(',',$transmas);
			$str.=" motor.transmission in ({$trans}) AND"; 
		}
		if($filter['privod']) 
		{
			$privod = explode(',',$_POST['privod']);
			foreach($privod as $val) 
			{
				$privodmas[] = "?";
				$mas[] = $val;
			}
			$privod = implode(',',$privodmas);
			$str.=" motor.privod in ({$privod}) AND"; 
		}
		if($filter['location']) 
		{
			$str.=" a.location = ? AND"; 
			$mas[] = $filter['location'];
		}
		if($filter['option'])
		{
			$strOption="";
			foreach($filter['option'] as $opt)
			{
				$strOption .= $opt.',';
			}
			$strOption = substr($strOption,0,-1);
			$str .= " col.filter_order in ({$strOption}) AND";
		}
		if($filter['vin'])
		{
			$str.=" LOWER(a.vin) LIKE LOWER(?) AND"; 
			$mas[] = '%'.$filter['vin'].'%';
		}
		if($filter['pricefrom'])
		{
			$str .= '(carprice.packprice+IFNULL(carprice.dopprice,0)+carprice.complectprice) > ? AND';
			$mas[] = $filter['pricefrom'];
		}
		if($filter['priceto'])
		{
			$str .= '(carprice.packprice+IFNULL(carprice.dopprice,0)+carprice.complectprice) < ? AND';
			$mas[] = $filter['priceto'];
		}
		if($filter['selected'])
		{
			$str .= "a.id in ({$filter['selected']}) AND";
		}

		$sort = ' a.location,(carprice.packprice+IFNULL(carprice.dopprice,0)+carprice.complectprice) ';
		if($filter['sort'])
		{
			if($filter['sort']=='mintomax') $sort = ' (carprice.packprice+IFNULL(carprice.dopprice,0)+carprice.complectprice) ';
			if($filter['sort']=='maxtomin') $sort = ' (carprice.packprice+IFNULL(carprice.dopprice,0)+carprice.complectprice) DESC ';
		}
		$having = "";
		if(!empty($filter['option']))
			$having = "HAVING COUNT(*) = ".count($filter['option'])." ";
		$brand = BRAND;
		$page = $amount*$page-$amount;
		
		$sql = "
			SELECT a.* FROM car_available as a 
			LEFT JOIN car_2_model as model on a.id_model = model.id 
			LEFT JOIN car_6_complect as complect ON a.id_complect = complect.id 
			LEFT JOIN carprice on a.id = carprice.id 
			LEFT JOIN car_3_motor as motor on complect.id_motor = motor.id 
			JOIN (SELECT DISTINCT filter_order,car_id FROM caroption) as col on col.car_id = a.id
			
			WHERE 
			{$str} model.id_mark = {$brand} AND a.status = 1 
			
			GROUP BY a.id
			
			{$having} 
			
			ORDER BY {$sort} 
			LIMIT ? OFFSET ?
		";
		//echo $sql;
		$mas[] = $amount;
		$mas[] = $page;
		$data = $this->getCustomSQL($sql,$mas);
		$model = new \app\models\car_2_model();
		$complect = new \app\models\car_6_complect();
		if(!is_array($data)) return false;
		foreach($data as $key=>$car)
		{
			$data[$key]->model = $model->getById($car->id_model);
			$data[$key]->complect = $complect->getComplectById($car->id_complect);
		}
		return $data;
	}

	public function getTotalCars($filter=array())
	{
		$str = '';
		$mas=array();
		$trans = array();
		$transmas=array();
		$privod=array();
		$privodmas=array();

		if($filter['model']) 
		{
			$str.=" model.id = ? AND"; 
			$mas[] = $filter['model'];
		}
		if($filter['transmission']) 
		{
			$trans = explode(',',$_POST['transmission']);
			foreach($trans as $val) 
			{
				$transmas[] = "?";
				$mas[] = $val;
			}
			$trans = implode(',',$transmas);
			$str.=" motor.transmission in ({$trans}) AND"; 
		}
		if($filter['privod']) 
		{
			$privod = explode(',',$_POST['privod']);
			foreach($privod as $val) 
			{
				$privodmas[] = "?";
				$mas[] = $val;
			}
			$privod = implode(',',$privodmas);
			$str.=" motor.privod in ({$privod}) AND"; 
		}
		if($filter['location']) 
		{
			$str.=" a.location = ? AND"; 
			$mas[] = $filter['location'];
		}
		if($filter['option'])
		{
			$strOption="";
			foreach($filter['option'] as $opt)
			{
				$strOption .= $opt.',';
			}
			$strOption = substr($strOption,0,-1);
			$str .= " col.filter_order in ({$strOption}) AND";
		}
		if($filter['vin'])
		{
			$str.=" LOWER(a.vin) LIKE LOWER(?) AND"; 
			$mas[] = '%'.$filter['vin'].'%';
		}
		if($filter['pricefrom'])
		{
			$str .= '(carprice.packprice+IFNULL(carprice.dopprice,0)+carprice.complectprice) > ? AND';
			$mas[] = $filter['pricefrom'];
		}
		if($filter['priceto'])
		{
			$str .= '(carprice.packprice+IFNULL(carprice.dopprice,0)+carprice.complectprice) < ? AND';
			$mas[] = $filter['priceto'];
		}
		if($filter['selected'])
		{
			$str .= "a.id in ({$filter['selected']}) AND";
		}
		$having = "";
		if(!empty($filter['option']))
			$having = "HAVING COUNT(*) = ".count($filter['option'])." ";
		$brand = BRAND;
		$sql = " 
			SELECT count(a.id) as total FROM car_available as a 
			LEFT JOIN car_2_model as model on a.id_model = model.id 
			LEFT JOIN car_6_complect as complect ON a.id_complect = complect.id 
			LEFT JOIN carprice on a.id = carprice.id 
			LEFT JOIN car_3_motor as motor on complect.id_motor = motor.id 
			JOIN (SELECT DISTINCT filter_order,car_id FROM caroption) as col on col.car_id = a.id
			
			WHERE 
			{$str} model.id_mark = {$brand} AND a.status = 1 
			
			GROUP BY a.id
			
			{$having} 
		";
		
		$data = ($this->getCustomSQLNonClass($sql,$mas));
		if(empty($data)) 
			return 0;
		return count($data);
	}

	public function getCountCar()
	{
		$brand = BRAND;
		$sql = "
			SELECT count(*) as total FROM {$this->table} as a
			JOIN car_2_model as model ON model.id = a.id_model
			WHERE  model.id_mark = {$brand} AND a.status = 1 ";
		$data = $this->getCustomSQLNonClass($sql)[0]['total'];
		return $data;
	}

	public static function getCountCarStatic()
	{
		$brand = BRAND;
		$car = new \app\models\car_available();
		$sql = "
			SELECT count(*) as total FROM {$car->table} as a
			JOIN car_2_model as model ON model.id = a.id_model
			WHERE  model.id_mark = {$brand} AND a.status = 1 ";
		$data = $car->getCustomSQLNonClass($sql)[0]['total'];
		return $data;
	}

	public static function getTestDriveCars()
	{
		$car = new \app\models\car_available();
		$model = new \app\models\car_2_model();
		$complect = new \app\models\car_6_complect();
		$motor = new \app\models\car_3_motor();

		$brand = BRAND;
		$sql = "
			SELECT a.* FROM {$car->table} as a
			JOIN car_2_model as model ON a.id_model = model.id
			WHERE model.id_mark = {$brand} and a.status = 3 ";
		$cars = $car->getCustomSQL($sql);
		foreach($cars as $key => $car)
		{
			$model->getRowById($car->id_model);
			$cars[$key]->model = clone $model;

			$complect->getRowById($car->id_complect);
			$cars[$key]->complect = clone $complect;

			$motor->getRowById($complect->id_motor);
			$cars[$key]->motor = clone $motor;
		}
		return $cars;
	}

	public function getAddres()
	{
		$model = new \app\models\car_2_model();
		$model = $model->getCustomSQLNonClass("
			SELECT country FROM {$model->getParam('table')} WHERE id = ?",
			array($this->id_model)
		)[0]['country'];

		if($this->location==1) return 'Склад<span style="color:#fff">-</span>Овен-Авто';
		if($this->location==2)
		{
			switch ($model) {
				/*зачем так сам уже не помню*/
				case '1':
					return \app\models\car_2_model::getOtgruz($model);
					break;
				case '2':
					return \app\models\car_2_model::getOtgruz($model);
					break;
				case '3':
					return \app\models\car_2_model::getOtgruz($model);
					break;
				case '4':
					return \app\models\car_2_model::getOtgruz($model);
					break;
				
				default:
					# code...
					break;
			}
		}
		if($this->location==3)
		{
			if(empty($this->adding))
			{
				switch ($model) {
					case '1':
						return "Завод Москва";
						break;
					case '2':
						return "Завод Тольятти";
						break;
					case '3':
						return "Завод Пусан (Корея)";
						break;
					case '4':
						return "Завод Танжер (Марокко)";
						break;
					default:
						# code...
						break;
				}
			}
			else{
				switch ($model) {
					case '1':
						return "Сборка {$this->getParam('adding')} ";
						break;
					case '2':
						return "Сборка {$this->getParam('adding')} ";
						break;
					case '3':
						return "Сборка {$this->getParam('adding')} (Ю.Корея)";
						break;
					case '4':
						return "Сборка {$this->getParam('adding')} (Марокко)";
						break;
					default:
						# code...
						break;
				}
			}
		}
	}














    /* HTML */
    public static function getCarForList($car='',$model='',$complect='',$motor='')
	{
	?>
		<div class="carList car-ava-block" style="">
				
				<?php $status="false";?>
				<?php $color = "#ddd;";?>
				<?php 
					foreach($_SESSION['cart'] as $key => $par) :
						$check="#000;";
						if($par==$car->id) {$color="#ff3b30";$status="true";}
					endforeach;
				?>
				<div 
					class="col-sm-2 text-center  icon-hover hidden-xs available-star" 
					id="car-select" 
					style="padding: 0px; " 
					check="<?=$status;?>" 
					data-param="<?=$car->id;?>"
				>
					<div class="">
						<i 
							
							title="Кликните на «Звездочку» и этот автомобиль будет добавлен на страницу сравнения моделей, кликните еще раз и автомобиль будет исключен из списка." 
							class="hovicon effect-3 sub-b icon-img fa fa-star-o" 
							style="background: transparent;color:<?=$color;?>;font-size:50px;"
						>
						</i>
						<span class="icon-text" style="color: #333">
							<?=$car->vin;?>
						</span>
					</div>
				</div>

				
				<!--a class="car-hover" target="" href="/content/viewavacar/<?=$car->id;?>"></a-->
				<div class="col-sm-3 text-center car-name-block aboutcar">
			
					<!--<i class="icofont icofont-auto-mobile"
					   style="font-size:40px; position:relative; left:15px;top:5px; color:#a5a5a5;" 
					>
					</i>-->
				<div style="padding-top: 15px;" class="visible-xs";>
					<!--Звезда которая на мобилках-->
					<div style="position: relative; float: right; text-align: center; display: inline-block;">
						<div 
								class="available-star visible-xs" 
								id="car-select" 
								style=" position: relative;  margin: auto; border-radius: 100%; z-index: 99;  border: 1px double #dcdcdc;
										width: 40px;
										height: 40px;" 

								check="<?=$status;?>" 
								data-param="<?=$car->id;?>"
							>
								<div class="" style="position: absolute;
									left: 50%;
									top: 50%;
									transform: translate(-50%, -50%);
									width: 28px;
									height: 30px;
									transition: .3s;">
									<i 
										class="icon-star fa fa-star-o" 
										style="color:<?=$color;?>;font-size:30px; margin-top 0px;"

									>
									</i>
								</div>
						</div>
						<div style="padding-top: 5px; font-size: 10px;">Запомнить</div>
					</div>
					<!--Машинка слева-->
					<?php 
					$temp=explode("/", $_SERVER['REQUEST_URI']);
					if ($temp[2]!="viewcar") : ?>
					<div style="position: relative; float:left; text-align: center; display: inline-block;">
						<div 
							class="icon-hover  available-star visible-xs" 
							id="car-select" 
							style=" position: relative; margin: auto; border-radius: 100%; z-index: 99;  border: 1px double #dcdcdc;
									width: 40px;
									height: 40px;" 
							check="<?=$status;?>" 
							data-param="<?=$car->id;?>"
							>
							<div class="" style="position: absolute;
									left: 50%;
									top: 50%;
									transform: translate(-50%, -50%);
									width: 34px;
									height: 34px;
									transition: .3s;">
								<a href="/content/viewcar/<?=$car->model->link;?>">
									<i 
										class="sub-b icofont icofont-auto-mobile"
										style="font-size:33px;margin-top:0px; color:#ddd;" 
									>
									</i>
						
								</a>
							</div>
							
						</div>
						<div style="margin: 0 auto; padding-top: 5px; font-size: 10px;">О модели</div>
					</div>
					
				<?php endif;?>
				</div>

					<div style="width: 90%; margin:auto; " class="hidden-xs">
						<?php 
                            unset($colorMas);
                            $colorMas = explode(',',$car->getColorCar()->web_code);
                            $img = 'http://admin.oven-auto.ru'.$model->alpha;
                            $background = $car->getColorCar()->web_code;
                            if(count($colorMas)>1){
                                if($model->name=="Kaptur"){
                                    if($colorMas[1]=='#fff') $img="http://admin.oven-auto.ru/content/cars/39/w.png";
                                    else $img = "http://admin.oven-auto.ru/content/cars/39/b.png";
                                    $background = $colorMas[0];
                                }
                            }
						?>
						<a href="/content/viewavacar/<?=$car->id;?>"><img style="width: 100%;background:<?=$background;?>" src="<?=$img;?>"></a>
					</div>




					<div style="width: 90%; margin:auto; padding-top: 40px" class="visible-xs">
						<?php 
                            unset($colorMas);
                            $colorMas = explode(',',$car->getColorCar()->web_code);
                            $img = 'http://admin.oven-auto.ru'.$model->alpha;
                            $background = $car->getColorCar()->web_code;
                            if(count($colorMas)>1){
                                if($model->name=="Kaptur"){
                                    if($colorMas[1]=='#fff') $img="http://admin.oven-auto.ru/content/cars/39/w.png";
                                    else $img = "http://admin.oven-auto.ru/content/cars/39/b.png";
                                    $background = $colorMas[0];
                                }
                            }
						?>
						<a href="/content/viewavacar/<?=$car->id;?>"><img style="width: 100%;background:<?=$background;?>" src="<?=$img;?>"></a>
					</div>

					<div class="car-name-color visible-xs" style="text-align: center; padding: 10px 10px 10px 10px; color:#333; font-size: 12px;"><?=$car->getColorCar()->name;?>
                         
					</div>

				</div>
	
				
					
					
				<div class="col-sm-5 aboutcar">
						<div class="pricesalepriz visible-xs" style="padding-bottom: 0px;display: flex;align-items: center;width: 100%; float:left;">
								<div style="width: 60%; float: left;">
									<?php if($car->sale==0 ) : ?>
										<span style="text-align: right; font-size:18px;">
											<?=\app\core\Html::money($car->getCarPrice());?> руб.</span>
									<?php else : ?>
										<span class="through" style="color: #000;text-decoration: line-through;   font-size:18px;">
											<?=\app\core\Html::money($car->getCarPrice());?> руб.</span>
									<?php endif;?>

									<?php if(!empty($car->sale)) : ?>
										<i class="icofont icofont-sale-discount"
											data-toggle="tooltip" 
										 
											class="" 
											src="/images/salemain.png"
											style="color: #ff3b30; z-index: 999; font-size:22px;  padding-left: 0px;" 
										>
										</i>
									<?php endif;?>
									<?php if($car->location==1 && $car->dopprice>0) : ?>
									<i class="icofont icofont-gift"
										data-toggle="tooltip" 
										
										class="" 
										src="/images/surprise.png"
										style="color: #ff3b30;z-index: 999; font-size:22px; padding-left: 0px;"
									>
									</i>
									<?php endif;?>
								</div>

								<div  style="width: 40%; float: left; margin: 2px 0;">
									<span class="background-red" style="background-color:#ff3b30;  float:right;"><?=$car->getLocationById($car->location,$car->adding);?>
										
									</span>
								</div>
							</div>

					<div class="available-car-info" style="position:relative;">
						<div class="hidden-xs" style="padding-bottom: 5px; display: inline-block;">
							<?php if($car->sale==0 ) : ?>
								<?=\app\core\Html::money($car->getCarPrice());?> руб.
							<?php else : ?>
								<span class="through" style="color: #000;text-decoration: line-through;">
									<?=\app\core\Html::money($car->getCarPrice());?> руб.
								</span>
							<?php endif;?>

						</div>


						<!-- -->
						<?php $status="false";?>
						<?php $color = "#ddd;";?>
						<?php 
							foreach($_SESSION['cart'] as $key => $par) :
								$check="#000;";
								if($par==$car->id) {$color="#ff3b30";$status="true";}
							endforeach;
						?>
						
						<!---->


						<span class="hidden-xs">
							<?php if(!empty($car->sale)) : ?>
								<i class="icofont icofont-sale-discount"
									data-toggle="tooltip" 
									title="На этом автомобиле снижена цена продажи. Чтобы узнать сумму скидки кликните по автомобилю и перейдите на страницу предложения."
									class="" 
									src="/images/salemain.png"
									style="margin-top:-8px;height: 30px;color: #ff3b30;display: inline-block;z-index: 999;" 
								>
								</i>
							<?php endif;?>


							<?php if($car->location==1 && $car->dopprice>0) : ?>
							<i class="icofont icofont-gift"
								data-toggle="tooltip" 
								title="При покупке этого автомобиля Вы получите подарок. Чтобы узнать, чем Вас порадует автосалон,  кликните по автомобилю и перейдите на страницу предложения." 
								class="" 
								src="/images/surprise.png"
								style="margin-top:-8px;height: 30px;color: #ff3b30;display: inline-block;z-index: 999;"
							>
							</i>
							<?php endif;?>
						</span>

					</div>

					<!--Подписи для мобилок-->

					<span class="visible-xs" style="">
						<?= $model->brand->name;?> <?= $model->name;?> VIN <?=$car->vin;?>
					</span>
				
					<div class="motorinfo visible-xs" style="padding-bottom: 9px;font-size: 14px;">
						<?=$car->year;?>
						<?=$complect->name;?> 
						<?=$motor->getMotorForUser($model->type);?> 
	
					</div>
					<!--END Подписи для мобилок-->

					<div class="car-name-color hidden-xs" style="font-size: 16px;">
                        <?= $model->brand->name;?> <?= $model->name;?>  <?=$car->getColorCar()->name;?> <span>(<?=$car->getColorCar()->rn_code;?>)</span>
						
					</div>
				
					
					
					<div class="motorinfo hidden-xs" style="padding-bottom: 9px; font-size: 16px;">
						<?=$car->year;?>
						<?=$complect->name;?>
						<?=$motor->getMotorForUser($model->type);?>
						<span class="hidden-xs">(<?=$complect->code;?>)</span>
					</div>
				</div>
					

				<div class="col-sm-2  text-center locationcell hidden-xs" style="">
					<div class="locationinfo">
						<?php 
							if(($car->location==1)) {
								$img="icofont icofont-key";
								$title="Этот автомобиля ожидает Вас на нашем складе. Кликните по автомобилю и перейдите на страницу предложения, вероятно, она уже дополнена живыми фотографиями.";
							}
							elseif(($car->location==2)) {
								$img="icofont icofont-auto-mobile";
								$title="В ближайшее время этот автомобиль поступит на склад. Он уже едет к нам на автовозе или ожидает погрузку на складе завода. Срок поставки совсем небольшой.";
							}
							else {
								$img="icofont icofont-help-robot";
								$title="Этот автомобиль запланирован в производство на заводе. Это означает, что он еще не готов, но дата сборки уже известна. Кстати, иногда еще не поздно поменять параметры машины (например, цвет или опции), для этого кликните по автомобилю и нажмите кнопку «Изменить опции».";
							}
						?>
						<!--i data-toggle="tooltip" title="<?=$title;?>" class="icon-img <?=$img;?>"  style="font-size: 60px;background: #fff;color:000;"></i-->
						<i data-toggle="tooltip" title="<?=$title;?>" class="hovicon effect-3 sub-b icon-img <?=$img;?>"  style=""></i>
						<span class="icon-text" style="color:#333;"> 
							<?=$car->getLocationById($car->location,$car->adding);?>
						</span>
					</div>
					<div class="opencar" style="display: none;">
						<a href="/content/viewavacar/<?=$car->id;?>" class="button button-yellow">Подробнее<i class="fa fa-angle-right"></i></a>
					</div>
				</div>

				<div class="visible-xs col-xs-12" style="padding-bottom: 10px;">
					<div class="opencar" >
						<a href="/content/viewavacar/<?=$car->id;?>" class="button button-yellow" style="background-color: #ddd;" >Подробнее<i class="fa fa-angle-right"></i></a>
					</div>
				</div>
		</div>
		<div class="clearfix"></div>
	<?php
	}
}

/*
CREATE VIEW carprice AS SELECT 
	car.id,
	IFNULL(complect.price,0) as complectprice,
    IFNULL(car.dopprice,0) as dopprice,
    IFNULL(sum(pack.price),0) as packprice
FROM car_available as car 
LEFT JOIN car_available_pack AS cap
	ON cap.id_car = car.id
LEFT JOIN car_7_pack as pack 
	ON pack.id = cap.id_pack
LEFT JOIN car_6_complect as complect
	ON complect.id = car.id_complect
GROUP BY car.id
*/

/*
CREATE VIEW caroption AS 
SELECT DISTINCT car.id as car_id,ol.id,ol.name,ol.filter_order 
FROM car_available as car 
LEFT JOIN car_5_option_value as cop ON cop.id_complect = car.id_complect 
LEFT JOIN car_available_pack as cap ON cap.id_car = car.id 
LEFT JOIN car_7_pack_value as cpv ON cpv.id_pack = cap.id_pack 
JOIN car_5_option_list as ol ON ol.id = cop.id_option OR ol.id = cpv.id_option 
ORDER BY car.id,ol.id 
*/