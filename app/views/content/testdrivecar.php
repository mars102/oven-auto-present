
<style>
	.carousel-control{visibility: hidden;}
	.control-view{visibility: visible !important;}
</style>
<input type="hidden" form="userModal" value="<?=$car->id;?>" name="id_avacar">

<div class="container block" style="padding-bottom: 10px;">
	

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
			$img = \app\core\Image::getImgList('http://admin.oven-auto.ru'.$car->path);

			if($img) :
				foreach ($img as $key => $value) :
					$photo[]['img'] = $value;
				endforeach;
			endif;
		?>
		<?=\app\models\banner::addSlider($photo);?>
		<!--BLOCK CAR PRICE-->
	</div>
</div>

<!--ABOUT CAR AGREGAT OPTION BEGIN-->
<div class="container block">
	<div class="row">
		
		<?php 
			\app\core\Html::carHead(
				$car->motor->getMotorForUser(),
				'Пробная поездка',
				$car->model->name,
				$car->complect->name,
				"",
				$car->sale,
				\app\models\car_available::getLocationById($car->location),
				$car->getAddres(),
				$car->model->link."/".$car->complect->id."/".strtolower($car->complect->name)
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
					<?php // number_format($car->complect->price,0,'',' ');?> 
				</div>
			</div>
			<!--END BLOCK COMPLECT PRICE-->
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
					<?php // number_format($car->complect->price,0,'',' ');?> 
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
						<div class="pack-price text-right">
							<div style="border-top:1px dashed #ccc"></div>
							<p ><?php //number_format($pack->price,0,'',' ');?>  </p>
						</div>
					<?php endforeach; ?>
				<?php endif;?>
	           
          	</div>

          	<?php if(($car->install) ) : ?>
				<div class="pack-list text-left">
					<b>Дополнительное оборудование</b>
				</div>
				<div style="padding: 0;">
					<?=nl2br($car->install);?>
				</div>
				<div style="border-top:1px dashed #ccc"></div>
				<div class="pack-price " style="">
					<span></span>
			       	<span style="float: right;">
			       		<?php //number_format($car->dopprice,0,'',' ');?><!-- руб.-->
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

<!--TEST DRIVE VIDGET BEGIN-->
	<?php 
		/*PageElements::vidgetTestDrive(
			$obj->current_model,
			$obj->current_complect,
			$obj->current_motor
		);*/
	?>
<!--TEST DRIVE VIDGET END-->

<!--KREDIT PROGRAMM BEGIN-->
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


<!--SALE BLOCK BEGIN-->
<a id="tosale" style=""></a>
<?php 
	/*PageElements::vidgetSale(
		$obj->current_car->getParam('sale'),
		$obj->current_car->getParam('vin'),
		$obj->current_model->getParam('name')
	);*/
?>
<!--SALE BLOCK END-->

<!--SALE BLOCK BEGIN-->
<a id="tosurprise" style=""></a>
<?php 
	/*PageElements::vidgetSurprise(
		$obj->current_car->getParam('location'),
		$obj->current_car->getParam('vin'),
		$obj->current_model->getParam('name')
	);*/
?>
<!--SALE BLOCK END-->

<!--PRICESTOCK BLOCK BEGIN-->
<?php 
	/*PageElements::vidgetPriceStock(
		$obj->current_model->getParam('name')." ".$obj->current_car->getParam('vin'),
		$obj->current_car->getParam('location')
	);*/
?>
<!--END BLOCK PRICESTOCK-->

<!--КОНЕЦ КОНТЕЙНЕРА ОБЁРТКА-->
	</div>
</div>

<!--ФОРМЫ-->
<?php if(is_array($form)) : ?>
<div class="container-fluid " style="" id="animate-block">
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
		})

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

<form action="/available/viewlist" method="POST" id='form-tab-car'>
	<input type="hidden" value="" name="model">
</form>


