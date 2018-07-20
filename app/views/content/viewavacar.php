<style>
	.carousel-control{visibility: hidden;}
	.control-view{visibility: visible !important;}
</style>

<input type="hidden" form="userModal" value="<?=$car->id;?>" name="id_avacar">

<div class="container block" style="padding-bottom: 10px;">
	<div class="col-sm-12 hidden-xs" style="padding:0px;">
	<!--<?php \app\core\Html::prA($car);?>-->

		<div class="col-sm-4">

			<!--Количесво машин в продаже данной марки-->
			<div class="col-sm-4 col-xs-4 hidden-xs" style="padding: 0px;">
				<a target="_blank" href="/content/viewcar/<?=$car->model->link;?>">
						<i 
							class="hovicon effect-3 sub-b icofont icofont-auto-mobile"
							style="display:block;margin:auto;margin-top:0px;" 
						>
						</i>
						<span style="color: #333"  class="icon-text">О модели
							<!--b>
								<span class="number-circle" id="summodel"><?= \app\models\car_available::getCountModel($car->model->id);?></span>
							</b-->
						</span> 
					</a>
				</div>

			<!--ОТКРЫТЬ PDF-->
			<div class="col-sm-4 col-xs-4" style="padding: 0px;">
				
					<!--div 
						class="hovicon effect-3 sub-b icon-hover text-center" 
						id="car-select" 
						style="padding: 0px; "
					>
						<a class="" target="_blank" href="/pdf/printcar/<?=$car->id;?>" style="padding: 0px; background:transparent;display:block;">
							<i 
								data-toggle="tooltip" class="icon-img icofont icofont-file-pdf" 
								style="font-size:40px;margin:auto;margin-top:0px;display:block;color:#ddd">
							</i>
							<span class="icon-text">Скачать</span>
						</a>
					</div-->
					<a target="_blank" href="/pdf/printcar/<?=$car->id;?>">
						<i 
							class="hovicon effect-3 sub-b icon-img icofont icofont-paper"
							style="font-size:40px;display:block;margin:auto;margin-top:0px;" 
						>
						</i>
						<span style="color: #333"  class="icon-text">Скачать</span> 
					</a>
			</div>
		</div>



		<!--СРАВНИТЬ-->
		<div class="col-sm-4 col-sm-offset-4 hidden-xs">
			<div class="col-sm-4 col-xs-4 col-sm-offset-4" style="padding:0px;">	
				<a id="header-count-car2" >
					<i class="hovicon effect-3 sub-b fa fa-sliders"
					 style="font-size:40px;display:block;margin:auto;margin-top:0px;" 
					>
					</i>
					<span style="color: #333"  class="icon-text">Сравнить	
						<b>
							<span class="cart-from number-circle" id="car-comparison">
								<?=\app\core\Html::getCountCart();?>
							</span>
						</b>
					</span> 
				</a>


		
					<form action="/content/compare" method="POST">
						<input type="submit" style="display:none;" name="selectedcars" id="selectedcars2">
					</form>
					<script>
						$("#header-count-car2").click(function(){
							$("#selectedcars2").click();
						})
						
						
					

					</script>	

				</div>

				<!--ДОБАВИТЬ В ИЗБРАННОЕ-->
				<div class="col-sm-4 col-xs-4 " style="padding:0px;">
						<?php $check="";?>
						<?php $status="false";?>
						<?php $color = "#ddd;";?>
						<?php 
							foreach($_SESSION['cart'] as $key => $par) :
								$check="#000;";
								if($par==$car->id) {$color="#a55";$status="true";}
							endforeach;
						?>
						<div 
							class=" text-center icon-hover-smal" 
							id="car-select"
							style="padding: 0px; " 
							check="<?=$status;?>" 
							data-param="<?=$car->id;?>"
						>
							<i 
								class="hovicon effect-3 sub-b icon-img fa fa-star-o"  
								style="font-size:40px;margin:auto;margin-top:0px;color: <?=$color;?>"
							></i>
							<span class="icon-text" style="color:#333">Запомнить</span>
						</div>
				</div>


		</div>

	</div>

	<div class="col-sm-6 col-sm-offset-3" style="padding:0px;">
		<!--BLOCK CAR PICTURE-->
		<?php 
			$perem = $car->getColorCar();
			if(!empty($perem)) : 
				$photo[0]['img'] 	= 'http://admin.oven-auto.ru'.$car->model->alpha;
				$photo[0]['color'] 	= $perem->web_code;
				$photo[0]['code'] = $perem->name." (".$perem->rn_code.")";
				$metalic = explode(',',$car->model->pay_color);
				if(in_array($car->color, $metalic))
					$photo[0]['metalic'] = "окраска кузова металлик";
				else
					$photo[0]['metalic'] = "окраска кузова не металлик";
			endif;
			$img = \app\core\Image::getImgList(ROOT.'../admin'.$car->path);
			//echo ROOT.'../admin'.$car->path;
			//\app\core\Html::prA($img);
			if($img) :
				foreach ($img as $key => $value) :
					$domen = "http://admin.oven-auto.ru";
					$start = strpos($value,'../admin/');
					$item = substr($value,$start);
					$item = str_replace('../admin',$domen,$item);
					$photo[]['img'] = $item;
				endforeach;
			endif;
		?>
		<?=\app\models\banner::addSlider($photo);?>
		<!--BLOCK CAR PRICE-->
	</div>

	<!--Верхние иконки на мобильных находятся под машиной-->
	<div style="text-align: center; padding-top: 35px;" class="visible-xs">
		<!--Машинка слева-->
					

				<div style="position: relative; float:left; text-align: center; display: inline-block;">
					<div 
						class="icon-hover  available-star visible-xs" 
						id="car-select" 
						style=" position: relative;  margin: 0 auto; border-radius: 100%; z-index: 99;  border: 1px double #dcdcdc;
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
							<a href="/content/viewcar/<?=$car->model->name;?>">
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

				<!--Печать на мобилках-->
				<div style="position: relative; text-align: center; display: inline-block;"> 
					<div 
						class="icon-hover  available-star visible-xs" 
						id="car-select" 
						style=" position: relative;  margin: 0 auto; border-radius: 100%; z-index: 99;  border: 1px double #dcdcdc;
								width: 40px;
								height: 40px;" 
						check="<?=$status;?>" 
						data-param="<?=$car->id;?>"
						>
						<div class="" style="position: absolute;
								left: 50%;
								top: 50%;
								transform: translate(-50%, -50%);
								width: 29px;
								height: 29px;
								transition: .3s;">
							<a target="_blank" href="/pdf/printcar/<?=$car->id;?>">
								<i 
									class="sub-b icofont icofont icofont-paper"
									style="font-size:28px;margin-top:0px; color:#ddd;" 
								>
								</i>
					
							</a>
						</div>

					</div>
					<div style="padding-top: 5px; font-size: 10px;">Скачать</div>
				</div>
					<!--Звезда которая на мобилках-->
				<div style="position: relative; float: right; text-align: center; display: inline-block;">	
					<div 
							class="available-star visible-xs" 
							id="car-select" 
							style=" position: relative; margin: 0 auto; border-radius: 100%; z-index: 99;  border: 1px double #dcdcdc;
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

	</div>
	<div class="hidden-xs" >
		<div class="car_name" style="width: 100%; padding:0px; padding-top:10px; position: relative; display: flex;">
		
		<div style=" margin: auto; display: flex;">

			<!--TEST CAR-->
			<?php 
		    	if(!empty($test)) : ?>
				    <div class="text-center hidden-xs" style="padding: 0px; position: relative;">
				  					
				    		<a class="icon-hover scrollto" href="#testdrive" style="pointer-events: auto;" >
								<i 
									class="hovicon effect-3 sub-b icofont icofont-steering" 
									style="font-size:40px;display:block;margin:auto;margin-top:0px;color:#ddd;" >
								</i>
								<span class="icon-text" style="color: #333">Тест-драйв
									<span class="number-circle-min" id="testcar"><b><?=(!empty($test))?count($test):0;?> а/м</b></span>
								</span> 
				    		</a>
				    </div>
			<?php endif;?>
			
		    <!--SALE-->
		    	<?php 
		    	if($countCompany['company_sale']) : ?>
		        	<span class="text-center hidden-xs" style="padding: 0px; position: relative;">
		    			<a class="icon-hover scrollto" href="#tosale" style="pointer-events:auto;">
							<i  
								class="hovicon effect-3 sub-b icon-img icofont icofont-sale-discount" 
								style="font-size:40px;display:block;margin:auto;margin-top:0px;color:"#ddd";" >
							</i>
							<span class="icon-text" style="color: #333">
								Скидка
								<span class="number-circle-min" id="stock">
									<b><?=$countCompany['company_sale'];?></b>
								</span>
							</span> 
		    			</a> 
		    		</span>
		    	<?php endif;?>
					
		    <!--SURPRISE-->
		    
		    	
		    		
		    	<?php if($countCompany['company_gift']) : ?>
    				<div class="text-center hidden-xs" style="padding: 0px; position: relative;">
    					<a class="icon-hover scrollto" href="#tosurprise" style="pointer-events: auto;">
    						<i 
    							class="hovicon effect-3 sub-b icon-img icofont icofont-gift"
    							style="font-size:40px;display:block;margin:auto;margin-top:0px;color: #ddd;" 
							>
							</i>
							<span style="color: #333"  class="icon-text">
								Подарок
								<span class="number-circle-min" id="stock">
									<b><?=$countCompany['company_gift'];?></b>
								</span>
							</span> 
						</a>
    				</div>
	    		<?php endif;?>		
		    			
		    		
				

				<!--ACTION-->
				<?php if($countCompany['company_action']) : ?>
				    <div class="text-center hidden-xs" style="padding: 0px; position: relative;">
						<a class="icon-hover scrollto" href="#" style="pointer-events: auto;">
							<i 
								class="hovicon effect-3 sub-b icon-img icofont icofont-rocket"
								style="font-size:40px;display:block;margin:auto;margin-top:0px;color: #ddd;" 
							>
							</i>
							<span style="color: #333"  class="icon-text">
								Акция 
								<span class="number-circle-min" id="stock">
									<b><?=$countCompany['company_action'];?></b>
								</span>
							</span> 
						</a>
				    </div>
				<?php endif;?>


				<!--Services-->
				<?php if($countCompany['company_service']) : ?>
		    		<div class="text-center hidden-xs" style="padding: 0px; position: relative;">
						<a class="icon-hover scrollto" href="#" style="pointer-events: auto;">
							<i 
								class="hovicon effect-3 sub-b icon-img icofont icofont-badge"
								style="font-size:40px;display:block;margin:auto;margin-top:0px;color: #ddd;" 
							>
							</i>
							<span style="color: #333"  class="icon-text">
								Сервисы 
								<span class="number-circle-min" id="services">
									<b><?=$countCompany['company_service'];?></b>
								</span>
							</span> 
						</a>
					</div>
		    	<?php endif;?>


				<!--BANK-->
	    		<div class="text-center hidden-xs" style="padding: 0px; position: relative;">
					<a class="icon-hover scrollto" href="#banki" style="pointer-events: auto;">
						<i 
							class="hovicon effect-3 sub-b icon-img icofont icofont-bank-alt"
							style="font-size:40px;display:block;margin:auto;margin-top:0px;color: #ddd;" 
						>
						</i>
						<span style="color: #333"  class="icon-text">Кредит <span class="number-circle-min" id="bank"><b>1 банк</b></span></span> 
					</a>
				</div>


			</div>
		    	
		 </div>
	</div>
	<!--END CAR PRICE-->
</div>

<!--ABOUT CAR AGREGAT OPTION BEGIN-->

<div class="container block">
	<div class="row">
		
		<?php 
			\app\core\Html::carHead(
				$car->motor->getMotorForUser(),
				$car->vin,
				$car->model->name,
				$car->complect->name,
				$car->getCarPrice()-$car->sale,
				$car->sale,
				\app\models\car_available::getLocationById($car->location),
				$car->getAddres()
			);
		?>

	 	<!--AGREGAT-->
		<div class="col-sm-4 hidden-xs" style="">
			<?php \app\core\Html::viewAgregat($car->motor,$car->complect->code);?>
			<?php if(!empty($car->complect->option)) : ?>
				<?php $countOption = (int)((count($car->complect->option)-5) / 2);?>
				<ul class="option-list" >
					<li><b>Комплектация <?=$car->complect->name;?></b></li>
					<?php for ($i=0;$i<$countOption;$i++) : ?>
						<li class="text-left"><?= $car->complect->option[$i]->name;?></li>
					<?php endfor; ?>
				</ul>
			<?php endif;?>
		</div>
		<!--END AGREGAT-->

		<div class="col-sm-4 hidden-xs" >
			<!--BEGIN OPTION-->
			<ul class="option-list" >
				<?php for ($i=$countOption;$i<count($car->complect->option);$i++) : ?>
					<li class="text-left"><?= $car->complect->option[$i]->name;?></li>
				<?php endfor; ?>
				<div style="border-top:1px dashed #ccc"></div>
			</ul>
			<!--END OPTION-->
			
			<!--BEGIN BLOCK COMPLECT PRICE-->
			<div class="pack-price" >
				<!--div style="padding-left: 5px;" class="col-sm-5 text-left"></div-->
				<div style="padding-right: 5px;" class="col-sm-12 text-right">
					<?= number_format($car->complect->price,0,'',' ');?> руб.
				</div>
			</div>
			<!--END BLOCK COMPLECT PRICE-->
		</div>

		<div class="visible-xs col-xs-12">
			<!--BEGIN TECH CHARACTER-->
			<?php \app\core\Html::viewAgregat(
				$car->motor,
				$car->complect->code
			);?>
			<!--END TECH CHARACTER-->
		</div>

		<!--BEGIN SMALL DISPLAY-->
		<div class="visible-xs col-xs-12" >
			<span class="click-option-complect">
				<b>Комплектация <?=$car->complect->name;?></b>
				<span style="" class="fa">подробнее</span>
			</span>
			<ul class="option-list option-list-disabled">
				<?php foreach($car->complect->option as $option) : ?>
					<li class="text-left"><?= $option->name;?></li>
				<?php endforeach; ?>
				
			</ul>
			<div style="border-top:1px dashed #ccc"></div>
			<!--BEGIN BLOCK COMPLECT PRICE-->
			<div class="pack-price" >
				<!--div style="padding-left: 5px;" class="col-sm-5 text-left"></div-->
				<div style="padding-right: 5px;" class="col-sm-12 text-right">
					<?= number_format($car->complect->price,0,'',' ');?> руб.
				</div>
			</div>
			<!--END BLOCK COMPLECT PRICE-->
		</div>
		<!--END SMALL DISPLAY-->

		<div class="col-sm-4 col-xs-12" style="float: left;">
			<div class="pack-list text-left">
				<b>Опционное оборудование</b>
			</div>

			<div class="pack-list" style="font-weight: normal;">
            	<span ><?=$car->getColorCar()->name;?>, <?=$photo[0]['metalic'];?></span>
            	<?php 
          			$background = $car->getColorCar()->web_code;
          			$bmas = explode(',', $background);
          			$color_type = "";
          			if(count($bmas)>1) 
          			{
          				$background = "linear-gradient(to top,".$bmas[0].' 50%,'.$bmas[1].' 50%)';
          				$color_type = ", двухцветная";
          			}
          		?>
          		<span id="current-code"><?=$color_type;?></span>
          	</div>
              
          	<div style="border-top:1px solid #fc3"></div>

          	<div class="pack-list text-left" style="padding-bottom: 30px;padding-top: 3px;">
          		
	            <span style="background: <?=$background;?>;border:1px solid #bbb;width: 20px;height: 20px; border-radius: 100%; display: inline-block;float: right;"></span>
	            <div style="height: 15px;"></div>
	            <div class="clearfix"></div>
	            <?php if(!empty($car->packs)) : ?>
					<?php foreach ($car->packs as $key => $pack) : ?>

						<div class="pack-name">
							<?= $pack->name;?>
						</div>
						<div class="pack-list text-left">
							<?= $pack->option_list;?> 
						</div>
						<div class="pack-price text-right" style="position: relative; ">
							<div style="border-top:1px dashed #ccc"></div>

							<p > <span style="float: left; font-size: 15px; color: #8c8c8c;" ><?= $pack->code;?></span><?=number_format($pack->price,0,'',' ');?> руб.</p>
						</div>

					<?php endforeach; ?>
				<?php endif;?>
	           
          	</div>

          	<?php if(($car->install) ) : ?>
				<div class="pack-list text-left">
					<b>Дополнительное оборудование</b>
				</div>
				<div style="padding: 0;">
					<?php echo nl2br($car->install);?>
				</div>
				<div style="border-top:1px dashed #ccc"></div>
				<div class="pack-price " style="">
					<span></span>
			       	<span style="float: right;">
			       		<?=number_format($car->dopprice,0,'',' ');?> руб.
			       	</span> 
			    </div>
			    <div style="width:100%;float:left;padding-bottom: 30px;"></div>
			<?php endif;?>

			<div class="clearfix"></div>

			<div style="">
				<a href="/content/configure/
					<?=$car->model->link;?>/
					<?=$car->complect->id;?>/
					<?=strtolower($car->complect->name);?>" 
					class="button button-black" style="margin-right: 0px;" >
				  		Изменить опции
				  		<i class="fa fa-angle-right" aria-hidden="true"></i>
				</a>
			</div>
			<!--div style="padding-top: 5px;">
				<?php \app\core\Html::modalTest();?>
			</div-->
		</div>
	</div>

</div>
<!--ABOUT CAR AGREGAT OPTION END-->


<?php 
	\app\models\company::getContainerCompany($company,$car);
?>

<!--SALE BLOCK BEGIN-->
<a id="tosale" style=""></a>
<?php 
	/*\app\core\PageElements::vidgetSale(
		$car->getCarPrice() - $car->sale,
		$car->sale,
		$car->vin,
		$car->model->name,
		$car->complect->name
	);*/
?>
<!--SALE BLOCK END-->

<!--SALE BLOCK BEGIN-->
<a id="tosurprise" style=""></a>
<?php 
	/*\app\core\PageElements::vidgetSurprise(
		$car->location,
		$car->vin,
		$car->model->name,
		$car->complect->name,
		$car->dopprice
	);*/
?>
<!--SALE BLOCK END-->

<!--PRICESTOCK BLOCK BEGIN-->
<?php 
	/*\app\core\PageElements::vidgetPriceStock(
		$car->model->name,
		$car->location,
		$car->vin
	);*/
?>
<!--END BLOCK PRICESTOCK-->


<!--TEST DRIVE VIDGET BEGIN-->
<a id="testdrive" style=""></a>
	<?php 
		if(!empty($test)) : 
			foreach ($test as $item) 
			{
				\app\core\PageElements::vidgetTestDrive(

					$item->model,
					$item->complect,
					$item->motor,
					$item->id
					
				);
			}
		endif;
	?>
<!--TEST DRIVE VIDGET END-->

<!--KREDIT PROGRAMM BEGIN-->
<a id="banki" style=""></a>
<?php if(is_array($kredit)) : ?>
	<?php 
		\app\core\PageElements::getKreditCarousel(
			$kredit,
			$car->model,
			"",
			""
		);
	?>
<?php endif;?>
<!--KREDIT PROGRAMM END-->




<!--КОНЕЦ КОНТЕЙНЕРА ОБЁРТКА-->
	</div>
</div>

<!--ФОРМЫ-->
<?php if(is_array($form)) : ?>
<!--ФОРМА ДЛЯ МОБИЛЬНЫХ-->	
<div class="mobilzvonok visible-xs">
    <div class="block-title">
		ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
	</div>
	<br>
	<div style="float: left ;width: 50%; text-align: center;">
		<a id="call" class="phone iconsize pulsar-2" href="tel:+78212288588">
			<span style="color: #71c766;"  class="fa fa-phone" aria-hidden="true"></span>
		</a>
		<div class="phone-desc">Позвонить сейчас</div>
	</div>
	
	<div style="float: left ;width: 50%; text-align: center;">
		<a id="call" style="border:solid 4px #3579b7;" class="phone iconsize pulsar-1 modalButton" data-form='send'>
			<span style="" class="fa fa-envelope" aria-hidden="true"></span>
		</a>
		<div class="phone-desc">Задать вопрос</div>
	</div>
	
	<div class="clearfix"></div>
</div>
<!--END ФОРМА ДЛЯ МОБИЛЬНЫХ-->
<div class="container-fluid hidden-xs" style="" id="animate-block">
	<div class="container" id="question" style="padding:0px;">
		<div class="row">
			<div class="block-title">
				ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
			</div>
			<div class="col-sm-12 text-center" style="font-size: 20px;">
				Мы рады, что Вас заинтересовал Renault <?=$car->model->name?> в комплектации <?=$car->complect->name?> 
				(VIN <span style="text-transform: uppercase;"><?=$car->vin;?></span>). 
				Дополнительную информацию о выбранном автомобиле Вы можете получить по телефону отдела продаж 8 (8212) 288 588 или задайте вопрос в форме ниже. Наши сотрудники свяжутся с Вами и постараются ответить на все вопросы.
			</div>

			<div class="col-sm-8 col-sm-offset-2" >
				<?php foreach ($data['form'] as $key => $form) : ?>
					<div class="">
						<?=$form->html;?>
						<input type="hidden" form="fcb<?=$form->id;?>" value="<?=$car->model->id;?>" name="model" >
						<input type="hidden" form="fcb<?=$form->id;?>" value="<?=$car->id;?>" name="available" >
						<input type="hidden" form="fcb<?=$form->id;?>" value="Страница автомобиля - 
							<?=$car->model->name.' '.$car->complect->name.' '.$car->vin;?>" 
							name="page" 
						>
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->







	</div>

</div>

<script>
	$(document).ready(function(){
		$(".ava-cars").click(function(){
			var id = $(this).attr("data-tab-car");
			$("#form-tab-car input").val(id);
			$("#form-tab-car").submit();
		});

		$("#carousel-example-generic").mouseenter(function(){
			//alert(1);
			$(this).find(".carousel-control").addClass("control-view");
		});
		$("#carousel-example-generic").mouseleave(function(){
			//alert(2);
			$(this).find(".carousel-control").removeClass("control-view");
		})
	})
</script>

<form action="/content/avaialablelist" method="POST" id='form-tab-car'>
	<input type="hidden" value="" name="model">
</form>

<?php 
	$carfor = 
		'<span >'.$car->vin.'<br/></span>'.
		'<span>'.\app\models\car_available::getLocationById($car->location).'<br/></span>'.
		'<b>'.$car->model->brand->name.' '.$car->model->name.' '.$car->complect->name.'<br/>'.
		$car->motor->getMotorForUser($car->model->type).'<br/>'.
		\app\core\Html::money($car->getCarPrice()-$car->sale).' руб.<br/></b>'.
		'<div class="dashed"></div>'.
		'<div class="divprice">Комплектация <span style="float:right">'.\app\core\Html::money($car->complect->price).' руб.</span></div>'.
		'<div class="divprice">Опции <span style="float:right">'.\app\core\Html::money($car->getPackPrice()).' руб.</span></div>'.
		'<div class="divprice">Доп. оборудование <span style="float:right">'.\app\core\Html::money($car->dopprice).' руб.</span></div>'.
		'<div class="divprice">Скидка <span style="float:right">'.\app\core\Html::money($car->sale).' руб.</span></div>'
		
	;
	$pic = 'http://admin.oven-auto.ru'.$car->model->alpha;
	$colmas[0] = $car->getColorCar()->web_code;
	if($car->model->name=='Kaptur')
	{
	  $color = $car->getColorCar();
	  $colmas = explode(',',$color->web_code);
	  if(count($colmas)==1)
	  {
	 	$pic = 'http://admin.oven-auto.ru'.$car->model->alpha;
	  }
	  else
	  {
		if($colmas[1]=='#000')
		  $pic = 'http://admin.oven-auto.ru/content/cars/39/b.png';
		else
		  $pic = 'http://admin.oven-auto.ru/content/cars/39/w.png';
	  }
	}
?>

<script>
	var carformodal = "<div class='col-sm-6'><img style='width:100%;background:<?=$colmas[0];?>' src='<?=$pic;?>'><div class='text-center carcolormodal'><?=$car->getColorCar()->name;?> (<?=$car->getColorCar()->rn_code;?>)</div></div>";
	var carformodaltext = "<div class='col-sm-6 bigblack'>"+'<?=$carfor;?>'+"</div>";
</script>



<script>
	var a = <?=\app\core\Html::getCountCart();?>;
	if (a <= 1) {$("#header-count-car2").css("display", "none");}

	$("#car-select").click(function() {
		//	var titleNew = document.getElementById("car-comparison");
		//var a=document.getElementById('car-comparison')[0].innerHTML
	    var b = $("#car-comparison").text();
	    b = parseInt(b);
	    if (b <= 1) 
	    	{$("#header-count-car2").css("display", "none");}
		else 
			{$("#header-count-car2").css("display", "inline-block");}

		circleclass("number-circle-min");
		circleclass("number-circle");
		//alert(b);
	
	})	


	// Закругление при 22 и при 2 разное
/*	function circle (idcircle){



		var numbercircle = $("#"+idcircle).text();
	if (typeof numbercircle !== "undefined"){};


		//numbercircle = parseInt(numbercircle);
		numbercircle = String(numbercircle);
		long = numbercircle.length;
		//alert(long);
		
		if (long == 1) 
			{ $("#"+idcircle).removeClass('circletwo circlethree').addClass('circleone');}
		else if (long == 2)
			{$("#"+idcircle).removeClass('circleone circlethree').addClass('circletwo'); }
		else if (long > 2) 
			{$("#"+idcircle).removeClass('circleone circletwo').addClass('circlethree');
			 $("#"+idcircle).css("right", "0px");
			}
	}	
	circle("summodel");
	circle("summodel1");
	circle("car-comparison");
	circle("testcar");
	circle("stock");
	circle("services");
	circle("bank");

	

	var count=$('.car_name>div').length;
	count=count-1;	
	if (count <= 2)
		{$("#centrdiv").addClass('col-sm-5 col-xs-5');}
	else if(count <=4 )
		{$("#centrdiv").addClass('col-sm-4 col-xs-4');}
	else if(count <= 6)
		{$("#centrdiv").addClass('col-sm-3 col-xs-3');}
	else if(count <= 8)
		{$("#centrdiv").addClass('col-sm-2 col-xs-2');}
	else if(count <= 10)
		{$("#centrdiv").addClass('col-sm-1 col-xs-1');}

*/
	
	
		

</script>

