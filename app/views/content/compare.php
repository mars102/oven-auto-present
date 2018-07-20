<style>
	.car-slider img{width: 100%;}
	.car-slider h2,.car-slider h3,.car-slider h4 {padding: 0px;margin: 0px;}
	.about{padding-bottom: 50px;}
	.about span{border-bottom: 1px dotted #ccc;}
	.table tr:nth-child(2n){background: rgba(0,0,0,0.05);}
	.autoplay {position: relative;}
	.autoplay .slick-prev {position: fixed;top: 200px;left: 100px;}
	.autoplay .slick-next {position: fixed;top: 200px;right: 100px;}
	.car-slider .pic{margin-bottom:10px;}
</style>

<div class="container">
	<div class="block-title"><?=$title;?></div>

	<div class="text-center" style="font-size: 20px;">
		На этой странице показаны автомобили, которые Вы отобрали для сравнения. Используйте вертикальную прокрутку, чтобы узнать их отличия по 		
		спецификациям оборудования. Если Вы сравниваете больше 3 автомобилей, используйте горизонтальную прокрутку (стрелки вправо/влево).
	</div>
	<div class="text-center" style="font-size: 20px;">
		Сейчас для сравнения Вами отобрано <?=$countCart;?> <?=\app\core\Html::getStrCars($countCart);?>.
	</div>
</div>

<div class="container block" style="padding-bottom: 15px;">
	<div class="row">
		<?php if(!empty($cars)) : ?>
		<div class="col-sm-12">
				<div class="col-sm-5 car-slider" data-menu='1' style=" padding-right: 0px;">
					<div class="pic text-center" style="display:flex;align-items:center;">
						
						<button name="clear" id="clear" class="compare-main-button">
							<i class="fa fa-trash"></i>
							Очистить
						</button>
						
						<a href="/content/availablelist" class="compare-main-button ">
							<i class="fa fa-plus-circle"></i>
							Добавить
						</a>

						<a class="modalButton compare-main-button" data-form="send" tabindex="0">
							<i class="fa fa-question-circle"></i>
							Спросить
						</a>

					</div>

					<div class="about text-left" style="">
						<span style="display: block;color: #333;font-size: 16px; padding-left: 5px;">VIN-номер автомобиля</span>
						<span style="display: block;color: #333;font-size: 16px; padding-left: 5px;">Модель автомобиля</span>
						<span style="display: block;color: #333;font-size: 16px; padding-left: 5px;">Комплектация автомобиля</span>
						<span style="display: block;color: #333;font-size: 16px; padding-left: 5px;">Исполнение комплектации</span>	
						<span style="display: block;color: #333;font-size: 16px; padding-left: 5px;">Код комплектации</span>
						<span style="display: block;font-size: 20px;font-weight: bold; padding-left: 5px;">Цена</span>
					</div>
					<table class="table">
						<tr><td class="location" style="font-size: 18px;">Этап поставки</td></tr>
					<?php foreach ($option as $key => $value) : ?>
						<tr>
							<td class="option" main="true" data-sub-class="<?=$key;?>" style="font-size: 15px; display: block;"><?=$value;?></td>
						</tr>
					<?php endforeach;?>
					</table>

					<div style="font-size: 20px;font-weight: bold;padding-left: 10px;">
						Дополнительное оборудование
					</div>
				</div>

				<div class="col-sm-7 " style="padding-left: 0px;">
				<div class="autoplay">
				<?php foreach ($cars as $key => $car) : ?>
					<div class="car-slider text-center" data-type="1" style="padding: 0px; padding-left: 6px; ">
					
					<?php 
						$background = $car->getColorCar()->web_code;
						
						$alpha = 'http://admin.oven-auto.ru'.$car->model->alpha;
						if($car->model->name=="Kaptur") : 
							$mas = explode(',',$background);

							if(count($mas)>1)
							{
								if($mas[1] == "#fff") $alpha = 'http://admin.oven-auto.ru/content/cars/39/w.png';
								if($mas[1] == "#000") $alpha = 'http://admin.oven-auto.ru/content/cars/39/b.png';

								$background = $mas[0];
							}
						endif;
					?>

						<div class="pic" style="position:relative;background:  <?= $background; ?>" >
							<img style="width: 100%;" src="<?=$alpha;?>">
							<button data-del-id="<?=$car->id;?>" class="delete-car-cart " style="margin-bottom: 5px;" >
								<i class="icofont icofont-close-line"></i>
							</button>
							<a target="_blank" class="button button-yellow" href="/content/viewavacar/<?=$car->id;?>">
								Подробнее<i class="fa fa-angle-right"></i>
							</a>
						</div>

						<div class="about" data-type="1" style="">
							<span style="display: block;color: #333;font-size: 16px;"><?=$car->vin;?> </span>
							<span style="display: block;color: #333;font-size: 16px;"><?=$car->model->name;?> </span>
							<span style="display: block;color: #333;font-size: 16px;"><?=$car->complect->name;?></span>
							<span style="display: block;color: #333;font-size: 16px;"><?=$car->motor->getMotorForUser($car->model->type);?></span>	
							<span style="display: block;color: #333;font-size: 16px;text-transform: uppercase;"><?=$car->complect->code;?></span>
								<?php $color="#333";?>
								<?php if(!empty($car->sale)) $color="red";?>
								<span style="display: block;color: <?=$color;?>;font-size: 20px;font-weight: bold;">
									<?=number_format($car->getCarPrice()-$car->sale,0,'',' ');?> руб.
								</span>
						</div>

						<table class="table"style="width: 100%;">
							<tr><td class="location" style="font-size: 15px;"><?=$car->getLocation();?></td></tr>
							<?php foreach ($car->compare as $key => $value) : ?>
								<tr>
									<td class="option" sub="true" data-sub-class="<?=$key;?>" style="font-size: 12px; color:#999;overflow: hidden; display: block;"><?=$value;?></td>
								</tr>
							<?php endforeach;?>
						</table>
						
						<div class="table-dop-ob text-left">
							
							<?php
							foreach (explode(PHP_EOL,$car->install) as $key => $value) {
								if($value!="")
									echo " $value <br/>";
							}
							?>

						</div>

						<div class="col-sm-12" style="background: #fff; padding:0px;padding-top: 15px;">
							<div class="col-sm-12" style="margin-bottom:5px;">
								<button data-del-id="<?=$car->id;?>" class="delete-car-cart button button-black" style="margin-bottom:5px; position:relative;left:0px;">
									Исключить<i class="icofont icofont-close-line"></i>
								</button>
							</div>
							<div class="col-sm-12">
								<a style="" target="_blank" class="button-yellow button" href="/content/viewavacar/<?=$car->id;?>">
									Подробнее<i class="fa fa-angle-right"></i>
								</a>
							</div>
						</div>

					</div>
				<?php endforeach;?>
				</div>
				</div>
		</div>
		<?php else : ?>
			<div class="block-title">
				Вы не выбрали ни одной машины
			</div>
		<?php endif; ?>
	</div>
</div>

