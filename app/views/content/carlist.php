<style type="text/css">
	.available img{
		width: 100%;
	}
	.filter-form select,.filter-forminput{
		width: 100%;
		padding: 7px 5px;
		margin-bottom: 7px;
		border-radius: 3px;
		border:1px solid #bbb;
	}
	.panel-renault .panel-heading{
		background: #fc3;
		color: #000;
	}
	.panel-title{font-size: 20px;}

</style>

<div class="container">

	<div class="row">
		<div class="block-title">
			<?=$title;?>
		</div>
		<div class="col-sm-12 text-center hidden-xs " style="font-size: 20px;">
			
			    Спасибо, что остановили свой выбор на марке Renault. 
				На этой странице представлены автомобили, которые 
				мы готовы предложить Вам для покупки. Чтобы Вы 
				смогли выбрать самый подходящий вариант, используйте 
				поиск по фильтру, - он позволит выбрать именно те 
				параметры, которые Вы хотите видеть в своем будущем автомобиле. 
			 
			   <div class="">Сегодня на сайте 
			   		<?=$availableCars.' '.\app\core\Html::getStrCars($availableCars);?>.
			   </div>
			
		</div>
			
		<div class="col-sm-12" id="filter-block"  style="">
			
			<form style="" action="/content/availablelist" method="POST"  class="filter-form " id="filter-form" >
			    
			    <div class="col-sm-4" style="padding-right:3px;">
					<select name="model" style="">
						<option value="0" selected="">Любая модель</option>
						<?php foreach (\app\models\car_2_model::ModelArray()as $key => $value) :?>
							<?php $check = "";?>
							<?php if($checkfilter['model']==$key) $check = "selected";?>
							<option <?=$check;?> value="<?=$key;?>"><?=$value;?></option>
						<?php endforeach;?>
					</select>
				</div>

				<div class="col-sm-4" style="padding-left:3px;padding-right:3px;">
					<select name="transmission">
						<option value="0" selected="">Любая трансмиссия</option>
						<?php foreach (\app\models\car_3_motor::getTransmissionForFilter() as $key => $value) :?>
							<?php $check = "";?>
							<?php if($checkfilter['transmission']==$value['params']) $check = "selected";?>
							<option <?=$check;?> value="<?=$value['params'];?>"><?=$value['type'];?></option>
						<?php endforeach;?>
					</select>
				</div>

				<div class="col-sm-4"  style="padding-left:3px;">
					<select name="privod">
						<option  value="0" selected="">Любой привод</option>
						<?php foreach (\app\models\car_3_motor::getPrivodForFilter() as $key => $value) :?>
							<?php $check = "";?>
							<?php if($checkfilter['privod']==$value['type']) $check = "selected";?>
							<option <?=$check;?> value="<?=$value['type'];?>"><?=$value['summary'];?></option>
						<?php endforeach;?>
					</select>
				</div>

				<div class="col-sm-4 "  style="padding-right:3px;">
					<select name="location">
						<option  value="0" selected="">Любой этап поставки</option>
						<?php foreach (\app\models\car_available::getLocationList() as $key => $value) :?>
							<?php $check = "";?>
							<?php if($checkfilter['location']==$key) $check = "selected";?>
							<option <?=$check;?> value="<?=$key;?>"><?=$value;?></option>
						<?php endforeach;?>
					</select>
				</div>

				<div class="col-sm-4" style="padding-left:3px;padding-right:3px;;">
					<div class="col-sm-6 col-xs-6" style="padding:0px;padding-right:0px">
						<input 
							class="pricetext"
							style="" 
							type="text" 
							name="pricefrom" 
							placeholder="Цена от, руб." 
							value="<?=number_format($checkfilter['pricefrom'],0,'',' ');?>" 
							oninput="this.value = this.value.replace(/\D/g, '')"
						>
						<div class="deletext">
							<i class="icofont icofont-close-line"></i>
						</div>
					</div>
				  	<div class="col-sm-6 col-xs-6" style="padding:0px;padding-left:0px">
						<input 
							class="pricetext"
							style="border-left:none;" 
							type="text" 
							name="priceto" 
							placeholder="Цена до, руб." 
							value="<?=number_format($checkfilter['priceto'],0,'',' ');?>"
							oninput="this.value = this.value.replace(/\D/g, '')"
						>
						<div class="deletext">
							<i class="icofont icofont-close-line"></i>
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-xs-12" style="padding-left:3px;">
				  	<input type="text" name="vin" placeholder="VIN автомобиля" value="<?=$checkfilter['vin'];?>">
				  	<div class="deletext">
						<i class="icofont icofont-close-line"></i>
					</div>
				</div>

				<div class="col-sm-12" style="height:0px;width:100%;"></div>
				
				<style>
				  @media screen and (min-width: 1100px){
					  	.column {
						    -webkit-column-width: 32%;
						    -moz-column-width: 32%;
						    column-width: 32%;
						    -webkit-column-count: 3;
						    -moz-column-count: 3;
						    column-count: 3;
						    -webkit-column-gap: 1%;
						    -moz-column-gap: 1%;
						    column-gap: 1%;
						    -webkit-column-rule: 1px solid #e9e9e9;
						    -moz-column-rule: 1px solid #e9e9e9;
							column-rule: 1px solid #e9e9e9;
					   }
				  }
				  @media screen and (min-width: 800px) and (max-width: 1099px) {
					  	.column {
						    -webkit-column-width: 45%;
						    -moz-column-width: 45%;
						    column-width: 45%;
						    -webkit-column-count: 2;
						    -moz-column-count: 2;
						    column-count: 2;
						    -webkit-column-gap: 1%;
						    -moz-column-gap: 1%;
						    column-gap: 1%;
						    -webkit-column-rule: 1px solid #ccc;
						    -moz-column-rule: 1px solid #ccc;
							column-rule: 1px solid #ccc;
					   }
				  }
				  @media screen and (max-width: 799px) {
					  	.column {
						    -webkit-column-width: 100%;
						    -moz-column-width: 100%;
						    column-width: 100%;
						    -webkit-column-count: 1;
						    -moz-column-count: 1;
						    column-count: 1;
						    -webkit-column-gap: 0%;
						    -moz-column-gap: 0%;
						    column-gap: 0%;
						    -webkit-column-rule: 0px solid #ccc;
						    -moz-column-rule: 0px solid #ccc;
						    column-rule: 0px solid #ccc;
					   }
					   .filter-form div.col-sm-4{
						   padding-left:15px !important;
						   padding-right:15px !important;
					   }
					   .filter-form div.col-sm-4 select,.filter-form div.col-sm-4 input[type="text"]{
							margin-bottom: 5px;
							border-left:1px solid #ccc;
						}
				  }
				  </style>

				

				<div class="col-xs-12 filter-form-option-link visible-xs text-center" style="margin-bottom: 10px;">
					<a><span class="filter-message">Больше параметров</span> <span class="fa-angle-down fa"></span></a>
				</div>
				<div class="col-xs-12 option-form-list" style="margin-bottom: 20px; float:left;">
				  	<div class="column" >
				 	<!--FORM OPTION PARAMETERS-->
						<?php $i = 1;?>
						<?php foreach ($filter as $key => $obj) : ?>
							<?php $i++;?>
							<span style="display: inline-block; width: 100%;">
								<?php $check="";?>
								<?php if(isset($checkfilter['option'])) : ?>
									
									<?php foreach ($checkfilter['option'] as $p => $num) : ?>
										<?php if($num==$obj) : ?>
											<?php $check = "checked";?>
										<?php endif;?>
									<?php endforeach; ?>
								<?php endif;?>
								<input 
									<?=$check;?> 
									type="checkbox"  
									class="checkbox" 
									id="checkbox<?=$obj;?>" 
									name="option[]" 
									value="<?=$obj;?>"/>
								<label style="font-weight: normal;" for="checkbox<?=$obj;?>"><?=$key;?></label>
							<!--/div-->
							</span>

						<?php endforeach;?>
					<!--FORM PARAMETER END-->
				  	</div>
				</div>
				
				<div class="clearfix"></div>

				<div class="col-sm-4  col-xs-12 " style="">
					<button name="clear" class="button button-black" id="clear-filter">
						Очистить
						<i class="icofont icofont-close-line"></i>
					</button>
				</div>

				<div class=" col-sm-4 col-xs-12 col-sm-offset-4" style="">
					<button class="button button-yellow" type="submit" name="submit" id="submit" style="margin-bottom: 5px;">
						Найти
						<i class="fa fa-angle-right"></i>
					</button> 
				</div>

			</form>
			
		</div>

		<?php if(!empty($countFilter)) : ?>
			<div class="col-sm-12 text-justify hidden-xs" style="float:left;font-size: 16px; padding: 20px 20px; background: #fd7;color: #555; margin-bottom: 20px; border-radius: 5px;">
				Вы использовали <?=$countFilter.' '.\app\core\Html::getStrParam($countFilter);?> фильтра. Найдено <?=$totalCars.' '.\app\core\Html::getStrCars($totalCars);?>. <br/>Чтобы выбрать лучшее предложение из найденных вариантов кликните по «звездочке» с VIN-номером и этот автомобиль будет добавлен на страницу сравнения моделей, кликните еще раз и автомобиль будет исключен из списка. Если результаты поисковой выдачи Вам не подошли, попробуйте исключить некоторые параметры или сбросьте фильтр, нажав кнопку «Очистить».
			</div>
		<?php endif;?>
			
		



		<div class="hidden-xs">
			<div class="col-sm-6">

				<button style="<?=$_SESSION['cartcolor'];?>" class="filter-sort non-border" form="filter-form" name="selectedcars" type="submit">
					<i class="fa fa-star-o" aria-hidden="true"></i> Только выбранные (<span class="cart-from"><?=\app\core\Html::getCountCart();?></span>)
				</button>

				<?php if(!empty($_SESSION['cartcolor'])) : ?>
					<form action="/content/compare" method="post" style="display:inline;">
						<button style="<?=$_SESSION['cartcolor'];?>" class="filter-sort non-border" type="submit">
							<i class="fa fa-sliders" aria-hidden="true"></i> Сравнить выбранные(<span class="cart-from"><?=\app\core\Html::getCountCart();?></span>)
						</button>
					</form>
				<?php endif;?>

			</div>
			<div class="col-sm-6 text-right">
				<button style="<?=$_SESSION['sortmincolor'];?>" class="filter-sort non-border" form="filter-form" name="sortmintomax" type="submit">
					<i class="fa fa-sort-amount-asc"></i> Сначала дешёвые
				</button>
				<button style="<?=$_SESSION['sortmaxcolor'];?>" class="filter-sort" form="filter-form" name="sortmaxtomin" type="submit">
					<i class="fa fa-sort-amount-desc"></i> Сначала дорогие
				</button>
			</div>
		</div>




		<!--КНОПКИ ДЛЯ МАЛОГО ДИСПЛЕЯ-->
		<div class="visible-xs" style="padding-bottom: 10px;">
			<div class="" style="">
				<div class="col-lg-12">
					<!--div class="col-xs-6" style="padding:5px;">
						<button style="width:100%;display:block;<?//=$_SESSION['cartcolor'];?>" class="filter-sort non-border" form="filter-form" name="selectedcars" type="submit">
							<i class="fa fa-star-o" aria-hidden="true"></i> Выбранные (<span class="cart-from"><?//=\app\core\Html::getCountCart();?></span>)
						</button>
					</div-->
					<!--div class="col-xs-6" style="padding:5px;">
						<?php //if(!empty($_SESSION['cartcolor'])) : ?>
				  			<form action="/content/compare" method="post">
								<button style="width:100%;display:block;<?//=$_SESSION['cartcolor'];?>" class="filter-sort non-border" type="submit">
									<i class="fa fa-sliders" aria-hidden="true"></i> Сравнить (<span class="cart-from"><?//=\app\core\Html::getCountCart();?></span>)
								</button>
							</form>
						<?php //endif;?>
					</div-->

					<div class="clearfix"></div>
					<div class="row container">
						<div class="col-xs-6" style="padding:5px;">
							<button style="width:100%;display:block;<?=$_SESSION['sortmincolor'];?>" class="filter-sort non-border" form="filter-form" name="sortmintomax" type="submit">
								<i class="fa fa-sort-amount-asc"></i> Сначала дешёвые
							</button>
						</div>
						<div class="col-xs-6" style="padding:5px;">
							<button style="float: right; <?=$_SESSION['sortmaxcolor'];?>" class="filter-sort" form="filter-form" name="sortmaxtomin" type="submit">
								<i class="fa fa-sort-amount-desc"></i> Сначала дорогие
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--КНОПКИ ДЛЯ МАЛЕНЬКОГО ЭКРАНА-->


		
		<div class="col-sm-12" style="width:100%;float:left;border-bottom:1px #fc3 solid;margin-top:10px;"></div>
		

		
		<div class="available-car " id="available-list" style="padding: 20px 0;">
			<?php if(is_array($cars)) : ?>
				<?php foreach ($cars as $key => $car) : ?>
					<?php \app\models\car_available::getCarForList($car,$car->model,$car->complect,$car->complect->motor);?>
				<?php endforeach;?>
			<?php else : ?>
				<div class="col-sm-12" style="padding:0px;padding-top:20px;">
					<div class="alert alert-danger" role="alert">
						К сожалению по заданным параметрам не найдено ни одного автомобиля.
					</div>  
				</div>
			<?php endif;?>
		</div>

	</div>


		<div class="text-center">
			<?php echo $pagination->getPagButtons();?>
		</div>
	
</div>

<!--ЗАКРЫВАЕТ АРЕА КОНТЕЙНЕР-->
</div>

<!--ФОРМЫ-->
<?php if(is_array($data['form'])) : ?>

<!--ФОРМА ДЛЯ МОБИЛЬНЫХ-->	
<div class="mobilzvonok visible-xs">
    <div class="block-title">
		ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
	</div>
	<br>
	<div style="float: left ;width: 50%; text-align: center;">
		<a id="call" class="phone iconsize pulsar-2" href="tel:+8(8212)288-588">
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

<div class="container-fluid hidden-xs" style="  " id="animate-block">
	<div class="container" style="padding:0px;">
		<div class="row">
			<div class="block-title">
				ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
			</div>
			<div class="col-sm-12 text-center" style="font-size: 20px;">
				Мы рады, что Вас заинтересовали автомобили Renault. Дополнительную информацию Вы можете получить по телефону отдела продаж 8 (8212) 288 588 или задайте вопрос в форме ниже. Наши сотрудники свяжутся с Вами и постараются ответить на все вопросы.
			</div>

			<div class="col-sm-8 col-sm-offset-2 col-xs-12" >
				<?php foreach ($form as $key => $form) : ?>
					<div class="">
						<?=$form->html;?>
						<input type="hidden" form="fcb<?=$form->id;?>" value="Страница автомобилей в продаже" name="page" >
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->

<script>
	/*PAGINATION*/
	$(".pagination a").click(function(e){
		e.preventDefault();
		$('<button>', {id:'pagbutton', name: 'pagbutton', style:'display:none'}).appendTo('#filter-form');
		$("#filter-form").attr('action',$(this).attr("href"));
		$("#filter-form #pagbutton").click();
	})
</script>

