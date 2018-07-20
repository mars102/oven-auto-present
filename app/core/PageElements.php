<?php
	/**
	* 
	*/
	namespace app\core;
	class PageElements
	{
		protected static $data = array();
		function   __construct()
		{
			//self::getData();
		}


		public static function getDataList()
		{
			
			$cars = \app\models\car_2_model::ModelLinkArray();
			$menus = \app\models\page::getMenus();
			return array('cars'=>$cars, 'menus'=>$menus);
			
		}
		

		private static function getData(){
			try{
				
				$param = \app\core\PageElements::getDataList();

				//\app\core\Html::prA($param['menus']);
				$data = "";

				$data .= "<li class='dropdown' style=''>";
				$data .= "<a 	href='#' 
								class='dropdown-toggle' 
								data-toggle='dropdown' 
								role='button' 
								aria-haspopup='true' 
								aria-expanded='false'>
								<i class='icofont icofont-auto-mobile'></i> Модельный ряд
								<span class='caret'></span>
						</a>";
				$data .= "<ul class='dropdown-menu'>";
				foreach ($param['cars'] as $key => $car) :
					$data .= "<li><a href='/content/viewcar/".$key."'>".$car."</a></li>";
				endforeach;
				$data .= "<li role='separator' class='divider'></li>";
				$data .= "<li><a href='/content/availablelist'>Автомобили в продаже</a></li>";	
				$data .= "</ul>";
				$data .= "</li>";

				foreach ($param['menus'] as $menu) :
					if($menu['name']=='Покупателям'){
						$cont = "<li class='dropdown'>";
						$cont .= "<a 	href='#' 
										class='dropdown-toggle' 
										data-toggle='dropdown' 
										role='button' 
										aria-haspopup='true' 
										aria-expanded='false'> <i class='icofont icofont-user-alt-1'></i> ".
										$menu['name']
											."<span class='caret'></span>
								</a>";
						$cont .= "<ul class='dropdown-menu'>";
						$cont .= "<li><a href='/content/kreditlist/'>Кредитные программы</a></li>"; 
						foreach ($menu['pages'] as $page) :
							$cont .= "<li><a href='/content/viewpage/".$page->id."/".$page->link."'>".$page->title."</a></li>";  
						endforeach;
						$cont .= "</ul>";
						$cont .= "</li>";
						$data .= $cont;;
					}
					elseif($menu['name']=='Владельцам'){
						$cont = "<li class='dropdown'>";
						$cont .= "<a 	href='#' 
										class='dropdown-toggle' 
										data-toggle='dropdown' 
										role='button' 
										aria-haspopup='true' 
										aria-expanded='false'></i> <i class='icofont icofont-users-alt-1'></i> ".
										$menu['name']
											."<span class='caret'></span>
								</a>";
						$cont .= "<ul class='dropdown-menu'>";
						$cont .= "<li><a href='/content/kreditlist/'>Кредитные программы</a></li>"; 
						foreach ($menu['pages'] as $page) :
							$cont .= "<li><a href='/content/viewpage/".$page->id."/".$page->link."'>".$page->title."</a></li>";    
						endforeach;
						$cont .= "</ul>";
						$cont .= "</li>";
						$data .= $cont;
					}
					else {
						$menu = (object)$menu;
						$data .= "<li class='dropdown'>";
						$data .= "<a 	href='#' 
										class='dropdown-toggle' 
										data-toggle='dropdown' 
										role='button' 
										aria-haspopup='true' 
										aria-expanded='false'>".
										$menu->name
											."<span class='caret'></span>
								</a>";
						$data .= "<ul class='dropdown-menu'>";
						foreach ($param['pages'] as $page) :
							$page=(object)$page;
							if($menu->id==$page->id_menu) :
								$data .= "<li><a href='/content/viewpage/".$page->id."/".$page->link."'>".$page->title."</a></li>";     
							endif;
						endforeach;
						
						$data .= "</ul>";
						$data .= "</li>";
					}
				endforeach;
				
				$data .= "<li><a href='/content/newslist'><i class='icofont icofont-mega-phone'></i> Новости</a></li>";
				$data .= "<li><a  href='/content/actionlist'><i class='icofont icofont-rocket'></i> Акции</a></li>";
				$data .= "<li><a href='/content/contact'><i class='icofont icofont-location-pin'></i> Контакты</a></li>";

				
				//$//data .= $contact;
				return $data;
				
			}
			catch (\PDOException $e) {
				echo "Error".$e->getMessage();
			}
		}


		public static function getMenu() { ?>

			<div class="container-fluid bot-header" style="padding:0px;">
		      <div class="col-sm-12" style="padding:0px;">
		      <nav class="navbar  ">
		      <div class="container-fluid">
		        
		        <!-- Brand and toggle get grouped for better mobile display -->
		        <div class="navbar-header">

		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		   
				  
		          <!--Меню для планшетов -->
				  <a class="navbar-brand hidden-xs" style="float:left;" href="/"><i class="fa fa-home"></i></a>

				  
				  <div class="visible-sm visible-md" >
				  	
					<div style="float: right; padding-left: 10px;">

					  <!--a class="visible-xs navbar-brand" href="/content/question"><i class="fa fa-commenting-o"></i></a>
					  <a class="visible-xs navbar-brand" href="/content/testform"><i class="fa fa-road"></i></a>
					  <a class="visible-xs navbar-brand" href="/content/service"><i class="fa fa-wrench"></i></a-->
						  
						<a id="header-count-car" class="small-dis-button navbar-brand visible-md visible-sm" style="position:relative;">
							
							<i class=" fa fa-star-o"></i>
							<span style="padding-left: 3px;">Избранное</span> 
							<b>
							<span 
								style="font-size:14px; background:#f00; color:#fff;" 
								class="countcars number-circle-right">
								<?=count($_SESSION['cart']);?>
							</span>
							</b>
							
						</a>
					</div>
					<div style="float: right; padding-left: 10px;">
					  	<form action="/content/availablelist" method="POST">
							<input type="submit" style="display:none;" name="selectedcars" id="selectedcars">
						</form>
						<script>
							$("#header-count-car").click(function(){
								$("#selectedcars").click();
							})
						</script>

						<a id="header-count-car" class="small-dis-button navbar-brand visible-md visible-sm" style="position:relative;" href="/content/availablelist">
							<i class=" icofont icofont-auto-mobile"></i>
							<span style="padding-left: 3px;"> Автомобили в продаже </span>
							<b>
							<span 
								style="font-size:14px; background:#fff; color:#333;" 
								class="number-circle-right">
								<?=\app\models\car_available::getCountCarStatic();?>
								
							</span></b>
							
						</a>
					</div>
					<div style="float: right; padding-left: 10px;">
					  <a class="small-dis-button navbar-brand modalButton visible-md visible-sm" data-form='send'>
					  
					  <i class="icofont icofont-ui-message"></i><span style="padding-left: 3px;"> Задать вопрос </span></a>
					</div>
				</div>

					<!-- END Меню для планшетов -->
					<!-- Меню для телефонов -->

				 <div class="visible-xs" style="width: 80%">
				 	 
				 	
					  <!--a class="visible-xs navbar-brand" href="/content/question"><i class="fa fa-commenting-o"></i></a>
					  <a class="visible-xs navbar-brand" href="/content/testform"><i class="fa fa-road"></i></a>
					  <a class="visible-xs navbar-brand" href="/content/service"><i class="fa fa-wrench"></i></a-->
					<div style="float: right; width: 25%">
						<a id="header-count-car1" class="small-dis-button navbar-brand visible-xs" style="position:relative;">
							
							<i class=" fa fa-star-o"></i>
							<span 
								style="font-size:14px;line-height:15px;border-radius:100%;background:#f00;color:#fff;width:15px;height:15px;text-align:center;position:absolute;top:7px;right:5px;" 
								class="countcars">
								<?=count($_SESSION['cart']);?>
							</span>
						</a>
					  	<form action="/content/availablelist" method="POST">
							<input type="submit" style="display:none;" name="selectedcars" id="selectedcars1">
						</form>
						<script>
							$("#header-count-car1").click(function(){
								$("#selectedcars1").click();
							})
						</script>
					</div>
					<div style="float: right; width: 25%">

						<a id="header-count-car" class="small-dis-button navbar-brand visible-xs" style="position:relative;" href="/content/availablelist">
							<i class=" icofont icofont-auto-mobile"></i>
							<span 
								style="font-size:14px;line-height:15px;border-radius:3px;background:#fff;color:#333;width:auto;height:15px;text-align:center;position:absolute;top:7px;right:-5px;padding: 0 2px;" 
								class="">
								<?=\app\models\car_available::getCountCarStatic();?>
							</span>
						</a>	
					</div>
					<div style="float: right; width: 25%">
					  <a class="small-dis-button navbar-brand modalButton visible-xs" data-form='send'>
					  	<i class="icofont icofont-ui-message"></i>
					  </a>
					</div>
					<div style="float: right; width: 25%">				 	
				 		<a class="navbar-brand" href="/"><i class="fa fa-home"></i></a>		
					</div> 
				 </div>					


					<!-- END Меню для телефонов -->





		        </div>

		        <!-- Collect the nav links, forms, and other content for toggling -->
		        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		          <ul class="nav navbar-nav">
		           
		            	<?php echo \app\core\PageElements::getData();?> 
		            
		          </ul>
		          <ul class="nav navbar-nav navbar-right">
		          	
			        <li>
						<a style='color: #fff000;' href="/content/availablelist"><i class="icofont icofont-auto-mobile"></i> Автомобили в продаже</a>
			        	<!--a href="/content/compare" id="cart-block">
			        		<i style="display: inline-block; padding-right: 10px" class="fa fa-star-o" aria-hidden="true" ></i>
			        		<span id="cart-str"><?php if(count($_SESSION['cart'])>0) echo "Сравнить автомибили: ";?></span>
						<span id="cart"><?=count($_SESSION['cart']);?></span></a-->
			        </li>
			      </ul>
		        </div><!-- /.navbar-collapse -->
		      </div><!-- /.container-fluid -->
		    </nav>
		    </div>
		    </div>

		<?php 
		}		

		public static function viewFooter($k=0)
		{
			$param = \app\core\PageElements::getDataList();
		?>
			<div class='col-sm-3 col-xs-12'>
				<h4>Модельный ряд</h4>
					<ul>
					<?php foreach ($param['cars'] as $key => $car) : ?>
						<li><a href='/content/viewcar/<?=$key;?>'>Renault <?=$car;?></a></li>
					<?php endforeach;?>
					<li><a href='/available/viewlist/'>Авто в продаже</a>
				</ul>
			</div>

			<?php foreach ($param['menus'] as $key => $menu) : ?>
				<div class='col-sm-3 col-xs-12'>
					<ul>
					<h4><?=$menu['name'];?></h4>
					<?php
					if($menu['id']==10 && $k==0)
					{
						$k++;
						echo"<li><a href='/content/kreditlist'>Кредитные программы</a></li>";
					}
					?>
					
					<?php foreach ($menu['pages'] as $page ) : ?>
						<li><a href='/content/viewpage/<?=$page->id;?>/<?=$page->link;?>'><?=$page->title;?></a></li>
					<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach;?>
			<div class='col-sm-3 col-xs-12'>
				<a style='color:#ddd;' href='/content/contact'><h4>Контакты</h4></a>
			</div>
		<?php
		}

		//СКИДКА НА ПОКУПКУ С САЙТА
		public static function vidgetSale($price="",$sale="",$vin="",$name="",$complect="")
		{
			if(!empty($sale)) : 
			?>
				<div class="container ">
					<div class="row vidget">
						<div class="col-sm-6 text-left">
							<img  src="/images/sale.jpg">
						</div>
						<div class="col-sm-6">
							<p class="vidgets_head hidden-xs"><b>Промо-акция на этот Renault <?=$name?> </b></p>
							<p class="vidgets_title">Скидка <?=Html::money($sale);?> руб. </p>
							<p class="vidgets_content">
								На Renault <?=$name;?> VIN <?=$vin;?> объявлена специальная цена продажи <?=Html::money($price);?> руб.
								(обычная цена такого автомобиля <?=Html::money($price+$sale);?> руб.) 
								Начните переговоры о покупке этого автомобиля на сайте и получите скидку <?=Html::money($sale);?> руб.
								при оформлении договора.
							</p>
							<div class="col-sm-6 but-block " >
								<a class="button button-black" href="/content/viewpage/39/discount">Подробнее об акции<i class="fa fa-angle-right"></i></a>
							</div>
							<div class="col-sm-6 but-block" >
								<?php Html::modalPay();?>
							</div>
						</div>
					</div>
				</div>
			<?php
			endif;
		}

		//ПОДАРОК ЗА ПОКУПКУ
		public static function vidgetSurprise($surprise="",$vin="",$name="",$complect="",$price="")
		{
			if(($surprise==1) && ($price!=0)) : 
			?>
				<div class="container ">
					<div class="row vidget">
						<div class="col-sm-6 text-left">
							<img  src="/images/surprise.jpg">
						</div>

						<div class="col-sm-6">
							<p class="vidgets_head hidden-xs"><b>Бонус за покупку этого Renault <?=$name;?></b></p>
							<p class="vidgets_title">Подарки на <?=Html::money(round($price*0.2,-2));?> руб.</p>
							<p class="vidgets_content">
								Начните переговоры о покупке Renault <?=$name;?> VIN <?=$vin;?> на сайте, оформите договор и выбирайте подарки на сумму 
								до <?=Html::money(round($price*0.2,-2));?> руб.
								Чем больше дополнительного оборудования установленно на автомобиле, тем ценнее будет Ваш подарок.
							</p>
							<div class="col-sm-6 but-block" >
								<a class="button button-black" href="/content/viewpage/39/discount">Подробнее об акции<i class="fa fa-angle-right"></i></a>
							</div>
							<div class="col-sm-6 but-block" >
								<?php Html::modalPay();?>
							</div>
						</div>
					</div>
				</div>
			<?php
			endif;
		}

		//ГАРАНТИЯ ЦЕНЫ
		public static function vidgetPriceStock($car="",$status="",$vin="")
		{
			if($status=="" || $status==3) : 
			?>
				<div class="container ">
					<div class="row vidget">
						<div class="col-sm-6 text-left">
							<img  src="/images/PriceStock.jpg">
						</div>
						<div class="col-sm-6">
							<p class="vidgets_head hidden-xs"><b>Акция на этот Renault <?=$car;?></b></p>
							<p class="vidgets_title">Скидка <span id="predsale">2%</span> и гарантия цены</p>
							<p class="vidgets_content">
								<?php if($vin!="") : ?>
									Renault <?=$car;?> VIN <?=$vin;?> ещё не поступил на наш склад в Сыктывкаре.
								<?php else : ?>
									Renault <?=$car;?> в таком исполнении будет найден и предложен Вам в ближайшее время.
								<?php endif;?>
								Если Вы готовы вместо обычного аванса (10 000 руб.) внести за него предоплату, мы зафиксируем указанную цену продажи на весь срок поставки автомобиля и предложим дополнительную скидку. 
							</p>
							<div class="col-sm-6 but-block" >
								<a class="button button-black" href="/content/viewpage/39/discount">Подробнее об акции<i class="fa fa-angle-right"></i></a>
							</div>
							<div class="col-sm-6 but-block" >
								<?php Html::modalPay();?>
							</div>
						</div>
						
					</div>
				</div>
			<?php
			endif;
		}

		public static function vidgetTestDrive($model,$complect,$motor,$id="")
		{
		?>
			<div class="container " style="">
				<div class="row vidget">
					<div class="col-sm-4 text-left">
						<img  src="/images/form/testdrive.jpg" style="width: 100%;">
					</div>

					<div class="col-sm-8" style="">
						<p class="vidgets_head hidden-xs"><b>Испытай в движении Renault <?=$model->name;?> </b></p>
						<p class="vidgets_title">Пробная поездка</p>

				
						<p class="vidgets_content" style="text-align: justify;">
							
								Комплектация автомобиля <?=$complect->name;?> 
								
								включает в себя:
								<span class="low">
									<?=\app\models\car_3_motor::getTypeForMotor($motor->type);?> 
									<?=$motor->valve;?> клапанный двигатель
								</span> c рабочии объемом 
								<span class="low">
									<?=($motor->size);?> л. 
									(<?=($motor->power);?> л.с.)
								</span>
								;
		    					КПП
		    					<span class="low">
		    						<?=\app\models\car_3_motor::getTransmissionName($motor->transmission);?>
		     					</span>
			     				;
		    					Привод 
		    					<span class="low">
		    						<?=$motor->getSummaryPrivod();?>
		    					</span>;
		    				
						</p>
						<div class="col-sm-6 but-block" >
							<a class="button button-black" href="/content/testdrivecar/<?=$id;?>">Подробнее о тест-драйве<i class="fa fa-angle-right"></i></a>
						</div>
						<div class="col-sm-6 but-block" >
							<?php \app\core\Html::modalTest();?>
						</div>
					</div>
				</div>
			</div>
		<?php
		}

		public static function vidgetCurrentDate()
		{
			$mas = array(
				"",
				"Январь",
				"Февраль",
				"Март",
				"Апрель",
				"Май",
				"Июнь",
				"Июль",
				"Август",
				"Сентябрь",
				"Октябрь",
				"Ноябрь",
				"Декабрь"
			);
			return $mas[date('n')].' '.date('Y');
		}

		public static function getKreditCarousel($programms,$model,$count,$beginprice)
		{
		?>
			<div class="container " style="margin-bottom:15px;	">

				<!--div class="why">
					<h2 class="text-center"><b>Кредитные предложения</b></h2>
				</div-->
				<div class="row">
				<div class="slick-center " style="width:100%;padding-top: 0px; margin-bottom: 0px;">
					<?php foreach($programms as $t => $programm) : ?>
						<div class=" vidget" >
							<div class="col-sm-4 col text-left banner-kredit">
								<img src="http://admin.oven-auto.ru<?=$programm->banner;?>" style="width: 100%;">
							</div>
							<div class="col-sm-8 " style="">
								<p class="vidgets_head hidden-xs"><b>Кредит на Renault <?=$model->name;?></b></p>
								<p class="vidgets_content hidden-xs">
									Кредитные предложения от Renault Finance помогут Вам приобрести Renault <?=$model->name;?> на выгодных условиях и обеспечат качественную страховую защиту. 
								</p>
								<p class="vidgets_title"><?=$programm->name;?></p>
								<p class="vidgets_content">
									<?php if($programm->rate || $programm->rate==0) :?>
										Ставка по кредиту <?=$programm->rate;?>% |
									<?php endif;?>

									<?php if($programm->pay) :?>
										 Ежемесячный платеж от <?=number_format($programm->pay,0,'',' ');?> руб. | 
									<?php endif;?>

									Первоначальный взнос от <?=$programm->contribution;?>% | 

									Срок кредита до <?=$programm->period;?>
									<?php 
										if($programm->period<=1) echo " года";
										elseif($programm->period>=2 && $programm->period<=4) echo " лет";
									?> 
									<?php if($programm->dopoption) : ?>
										| <?=$programm->dopoption;?>
									<?php endif;?>
								</p>

								<div class="col-sm-6 block-but1" style="">
									<a class="button button-black" href="/content/kreditlist/" style="">
										Подробнее о кредитах<i class="fa fa-angle-right"></i>
									</a>
								</div>
								<div class="col-sm-6 block-but2 " style="" >
									<?php Html::modalPay();?>
								</div>

							</div>

							<div class="col-sm-12  text-justify disklamer" style="padding-top: 15px;">
								<div class="accordion-wrap">

								    <section class="accordion-item">
								    <input type="checkbox" id="accordion-one<?=$t;?>" name="accordion-group">
								    <label for="accordion-one<?=$t;?>" onclick="">Юридическая информация<i style="float:right;padding-top: 3px;" class="fa fa-angle-down"></i></label>

								      <div class="accordion-content">
								        <p class="text-justify disklamer"><?=$programm->disklamer;?></p>
								      </div><!-- .accordion-content -->
								    </section><!-- .accordion-item -->

								</div>
							</div>
						</div>
					<?php endforeach;?>
				</div>
				</div>
			</div>

		<?php
		}
	}
