<?php
namespace app\core;
class Html{
	public static function prA($array = array()) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
	public static function money($money)
	{
		if(is_numeric($money))
			return number_format($money,0,'',' ');
	}
	public static function formatStr($str)
    {
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }

    public static function viewTechChar($charlist)
    {
    ?>
		<style>
			.techcharlist{font-size: 20px;}
			.techcharlist div li:nth-child(2n){background: linear-gradient(to left,#fff,#efefef,#fff);}
			.techcharlist li{padding: 3px 0px;}
			.texhcharlist div{padding: 0px;}
			@media screen and (max-width:700px){
				.techcharlist{font-size: 12px;}
			}
		</style>
		<ul class="techcharlist " style="list-style-type: none;padding-left: 15px;">
		<?php foreach($charlist as $key => $char) : ?>
			<?php if($key==0) : ?> <div class="col-sm-6" style="padding: 0px;"><?php endif;?>
			<?php if($key==(int)((count($charlist))/2)) : ?></div><div class="col-sm-6" style="padding: 0px;"><?php endif;?>
				<li style="float: left;width: 100%;">
					<div style="padding-left:0px;float: left;width: 100%;">
						<div class="col-sm-7 col-xs-7 text-left" style="padding-left: 0px;">
							<?= $char->name;?> 
						</div>
						<div class="col-xs-5 col-sm-5 text-right">
							<?=$char->value->value;?>
						</div>
					</div>
				</li>
			<?php if (!next($charlist)) : ?></div><?php endif;?>
		<?php endforeach; ?>
		</ul>
	<?php
    }

    public static function viewAgregat($motor="",$code="")
    {
    	?>
    	
			<ul class="option-list ">
				<li><b>Исполнение <?=$code;?></b></li>
				<li >
					Двигатель
					<span style="text-transform: lowercase;">
						<?=\app\models\car_3_motor::getTypeForMotor($motor->type);?>
					</span>
					<?=$motor->valve;?> клапанный
				</li>
				<li>
					Рабочий объем 
					<?=($motor->size);?> л. 
					(<?=($motor->power);?> л.с.)
					
				</li>
		    	<li> КПП 
						<span style="text-transform: lowercase;">
							<?=\app\models\car_3_motor::getTransmissionName($motor->transmission);?>
						</span>
					</li>
		    	<li  >Привод 
						<span style="text-transform: lowercase;">
							<?=$motor->getSummaryPrivod();?>
						</span>
					</li>
		    	<li> &nbsp</li>
			</ul>
		
		<?php
    }	

    

    /*CAR HEAD*/
    public static function carHead(
    	$motor="",
    	$page="",
    	$model_name="",
    	$complect_name="",
    	$price="",
    	$sale="",
    	$location="Подготовка заказа",
		$locationdesc="",
		$test="")
    {
    ?> 
    	<?php 
    	if($locationdesc=="")
    	{
    		$conf_title = "В большинстве случаев ожидание автомобиля с заявкой на 
    						изменение опций или цвета занимает не больше месяца. 
    						Точную дату сборки мы озвучим сразу после обработки 
    						Вашего запроса. Просто выберите новые параметры 
    						автомобиля и нажмите «Обсудить покупку».";
				$locationdesc = "
				<span id='postavka'>
					<span id='changed'>
						Выберите цвет 
						<span class='p1'>.</span>
						<span class='p2'>.</span>
						<span class='p3'>.</span>
					</span>
					<span id='hid' style='display:none'>
						Прогноз <span id='datechange'>".date('d.m.Y',strtotime("+33 days"))."</span> 
						<i data-toggle='tooltip' title='".$conf_title."' class='fa fa-question-circle myhelp' aria-hidden='true'></i>
					</span>
				</span>";
				
    	}
    	?>
	    <style>
	    .uperavacarinfo {font-size: 20px;}

	    @media screen and (min-width: 1000px) and (max-width: 1200px){
	    	.car-head .car_name{font-size: 26px;}
	    }
	    @media screen and (max-width: 999px){
	    	.car-head .car_name{font-size: 22px;}
	    }
	    </style>
	<div class="car-head" style="overflow:hidden;">
	    <div id="car_price">
		    <div class="col-sm-4 " >
				<div class=" uperavacarinfo">
					<?=$page;?>
				</div>
			</div>
			<div class="col-sm-4 hidden-xs" >
				<div class=" uperavacarinfo" >
					Этап поставки
				</div>
			</div>
			<div class="col-sm-4 hidden-xs" >
				<div class=" uperavacarinfo" >
					<?php 
						if(empty($sale))
							echo "Цена продажи";
						else
							echo "Цена со скидкой";
					?>
					<div style="padding-top:5px;float:right;"><?php \app\core\Html::socseti();?></div>
				</div>
			</div>


			<div class="col-sm-12">
				<div style="margin-top: 5px;margin-bottom: 5px;height: 1px;background: #ccc;"></div>
			</div>


			<div class="col-sm-4 " >
		      <div class="uperavacarinfo car_name">
		        Renault <?=$model_name;?>
		      </div>
		    </div>

		    <div class="col-sm-4 hidden-xs">
				<div class=" uperavacarinfo car_name" >
					<?=$location;?>
				</div>
		    </div>

		    <div class="col-sm-4 ">
		      
				<div class="uperavacarinfo car_name " >
				<?php 
					if(empty($sale)) $class_sale = "";
					else $class_sale = "color: #800;";
				?>
				<?php if(!empty($price)) : ?>
					<span id="total-price" style="<?=$class_sale;?> "><?=number_format($price,'0','',' ');?></span> 
					<span style="<?=$class_sale;?>">&nbsp;руб.</span>
					<?php 
						if(!empty($sale)) $str = "Цена по прайсу ".number_format($price+$sale,0,'',' ')."руб. Цена со скидкой ".number_format($price,0,'',' ')." руб.";
						else $str = "Цена по прайсу ".number_format($price,0,'',' ')." руб.";
					?>
					
				<?php else : ?>
					
					<?=Html::modalTest();?>

				<?php endif;?>
				

				
				</div>

			</div>
			
		</div>
			
			
		<div class="clearfix"></div>

		<!--БЛОК КНОПОК-->
		<div class="col-sm-4 car_name hidden-xs">
			<!--span style="display: inline;" class="hidden-sm">Renault <?=$model_name;?></span-->
			<?=$complect_name;?> 
			<!--i data-toggle="tooltip" title="<?=$motor;?> " class="fa fa-question-circle myhelp" aria-hidden="true"></i-->
		</div>
		<div class="col-sm-4 car_name " >
			<?=$locationdesc;?>
		</div>
		<div class="col-sm-4 button-padding" >
			<?php if($page=="Пробная поездка") : ?>
							<a href="/content/configure/<?=$test;?>" 
								class="button button-black" style="margin-right: 0px;" 
							>
								Изменить опции
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</a>
				<?php else : ?>
					<?php Html::modalPay();?>
				<?php endif;?>
		</div>
		<!--КОНЕЦ БЛОК КНОПОК-->

	    

	    <div class="clearfix">
	      <!--div style="margin-top: 5px;margin-bottom: 10px;height: 1px;"></div-->
	    </div>
	</div>
	<?php
	}




	public static function select($name,$label="",$arraVal="",$selected="",$first="", $disabled="")
    {
    ?>
		<select <?=$disabled;?> name="<?=$name;?>" id="<?=$name;?>">
			
			<?php if($label) : ?>
				<option selected="" disabled=""><?=$label;?></option>
			<?php endif;?>

			<?php if(is_array($arraVal)) : ?>
				<?php foreach ($arraVal as $key => $value) : ?>

					<?php $current = "";?>
					<?php if((string)$selected === (string)$key) $current = "selected"; ?>
					<option <?=$current;?> value="<?=$key;?>"><?=$value;?></option>
					
				<?php endforeach;?>
			<?php endif;?>
			
		</select>
	<?php
    }

    /*BUTTONS*/
    public static function modalQuestion()
    {
    ?>
    	<a class="button button-yellow modalButton" data-form='send'>Задать вопрос<i class="fa fa-angle-right"></i></a>
    <?php
    }

    public static function modalTest()
    {
    ?>
    	<a class="button button-yellow modalButton" data-form='test'>Пройти тест-драйв<i class="fa fa-angle-right"></i></a>
    <?php
    }

    public static function modalPay()
    {
    ?>
    	<a class="button button-yellow modalButton" data-form='rezerv'>Обсудить покупку<i class="fa fa-angle-right"></i></a>
    <?php
		}
		
		public static function getStrParam($count)
		{
			if($count%10==1) return "параметр";
			if($count%10>1 && $count%10<5 && $count!=11 && $count!=12 && $count!=13 && $count!=14) return "параметра";
			return "параметров";
		}
		public static function getStrCars($count)
		{
			if($count%10==1) return "автомобиль";
			if($count%10>1 && $count%10<5 && $count!=11 && $count!=12 && $count!=13 && $count!=14) return "автомобиля";
			return "автомобилей";
		}

		public function getCountCart()
		{
			foreach($_SESSION['cart'] as $key=>$value)
			{
				if(empty($value))
					unset ($_SESSION['cart'][$key]); 
			}
			if(!empty($_SESSION['cart']))
			{
				return count($_SESSION['cart']);
			}
			return 0;
		}

		public function socseti()
		{
			?>
					<!--SCRIPT SOC SETI-->
					<!--div class="container text-right">
						<div class="col-sm-12"-->
							<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
							<script src="//yastatic.net/share2/share.js"></script>
							<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki" data-counter=""></div>
						<!--div>
					</div-->
					<!--END SOC SETI-->
			<?php
		}
}
?>
