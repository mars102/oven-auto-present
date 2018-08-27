<input type="hidden" form="userModal" value="<?=$models->id;?>" name="id_model" >

<div class="container-fluid banner-main ">
	<img src="http://admin.oven-auto.ru<?= $models->banner; ?>">
</div>

<div class="container-fluid bg-ccc ">
	<div class="container " style="padding: 20px 0;">
		<div class="row">
			<div class="col-sm-3 border-right">
				<span class="small-price-info">Начальная цена</span>
				<span class="big-price"><?= number_format(\app\models\car_6_complect::minPrice($models->id),0,'',' ');?> руб.</span>
			</div>
			<div class="col-sm-5 border-right">
				<span class="small-price-info">Кредитные предложения</span>
				<span class="big-price">
					<div class="kredit_banners">	
						<?php foreach ($data['kredit_banner'] as $key => $value) :?>
							<div style=""><?=$value;?></div>
						<?php endforeach;?>
					</div>
				</span>
			</div>
			<div class="col-sm-4 text-left">
				<div class="small-price-info">Сейчас в продаже</div>
				<div class="big-price">
					<?=\app\models\car_available::getCountModel($models->id);?>
					<?=\app\core\Html::getStrCars(\app\models\car_available::getCountModel($models->id));?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container hidden-xs" style="padding-bottom: 0px;z-index: 999;">
	<div class="row">
		<div class="about-car col-sm-10 col-sm-offset-1  text-center">
			<div class="block-title">
				<?=$models->label;?> <?=$models->brand->name;?> <?=$models->name;?>
				<i class="sub-title hidden-xs">
					<?= $models->slogan;?>
				</i>
			</div>
			<span class="hidden-xs" style="z-index: 999;"><?= $models->text;?></span>
		</div>
	</div>
</div>

<?php if(!empty($models->documents)): ?>
	<?php $models->documents->getDocBlock();?>
<?php endif; ?>

<div class="container " style="padding-bottom: 20px; z-index: 1; ">
	<div class="col-sm-6 col-sm-offset-3" style="padding:0px;">
		<div class="" style="">
        		<img class="present a" src="http://admin.oven-auto.ru<?=$models->alpha;?>" style="z-index: 1; width: 100%;"/>
        	<?php if($models->name=='Kaptur') : ?>
        		<img  class="present w" src="http://admin.oven-auto.ru/content/cars/39/w.png" style="z-index: 1; width: 100%; display: none;"/>
        		<img  class="present b" src="http://admin.oven-auto.ru/content/cars/39/b.png" style="z-index: 1; width: 100%; display: none;"/>
        	<?php endif;?>
      	</div>
      	<div class="color-block text-center" style="">
        	
        	<?php
        		$button_1 = "";
	            $button_2 = "";
	            $button_3 = "";
			?>
			<?php if(is_array($models->palette)) : ?>
	        <?php foreach ($models->palette as $color) :?>
	        	
	            <?php 
	            	$val = "a";
	            	$pay_color="";

                	$search = ','.$color->id.',';
	        		$string = $models->pay_color;
	        		if(strripos($string,$search)!==false) $pay_color = "true";
                	else $pay_color = "false";

	            	$background = $color->web_code;
	            	$data_color = $color->web_code;
	            	$type = explode(',',$color->web_code);
	            	
	            	if(count($type)>1){
	            		$background = 'linear-gradient(to top,'.$type[0].' 50%, '.$type[1].' 50%)';
	            		$data_color = $type[0];

	            		if($type[1]=='#fff') {
	            			$val = 'w';
	            			$button_1 .= '
	            			 <div'.
	            			 	' class="color-button"'.
	            				' data-color-name="'.$color->name.' ('.$color->rn_code.')"'.
	            				' data-color="'.$data_color.'"'.
					            ' data-type="'.$val.'"'.
					            ' style="background: '.$background.'"'.
					            ' color-pack="q" '.
					            ' pay-color = "'.$pay_color.'" >'.
					        '</div>';
	            		}
	            		else {
	            			$val = 'b';
	            			$button_3 .= '
	            			 <div'.
	            			 	' class="color-button"'.
	            				' data-color-name="'.$color->name.' ('.$color->rn_code.')"'.
	            				' data-color="'.$data_color.'"'.
					            ' data-type="'.$val.'"'.
					            ' style="background: '.$background.'"'.
					            ' color-pack="q" '.
					            ' pay-color = "'.$pay_color.'" >'.
					        '</div>';
	            		}
	               	}
	            	else{
	            		$button_2 .= '
	            			<div'.
	            				' class="color-button"'.
	            				' data-color-name="'.$color->name.' ('.$color->rn_code.')"'.
	            				' data-color="'.$data_color.'"'.
					            ' data-type="'.$val.'"'.
					            ' style="background: '.$background.'"'.
					            ' color-pack="q" '.
					            ' pay-color = "'.$pay_color.'">'.
					        '</div>';
	            	}
	            ?>
	          
			<?php endforeach;?>
			<?php endif;?>
			
			<?=$button_2;?><br/><?=$button_3;?><br/><?=$button_1;?>
			<div id="text-color" style="" class="car-color-name"></div>
	        
      	</div>
	</div>
</div>

<!--ТЕХНИЧЕСКИЕ ХАРАКТЕРИСТИКИ-->
<div class="container " >
	<div class="row">
	
		<div class="col-sm-12" style="border-bottom: 1px solid #dfdfdf;">
			<h3 data-status='1' class="complect-name-link" style="padding-bottom:0px;font-family: renault-regular; font-weight: normal; " id="opencharlist">
				
				<b class="visible-xs" style="font-size: 15px; float:left;">Характеристики</b>
				<i style="font-size: 14px; float: right; color: #777;padding-right: 2px; " class="fa fa-angle-down visible-xs"></i>	
				<br>

				<b class="hidden-xs" style="">Характеристики</b>
				<i style="float: right;color: #777;padding-right: 2px; font-size: 28px" class="fa fa-angle-down hidden-xs"></i>

			</h3>
		</div>

		<div class="" style="float: left;display: none;width: 100%;" id="texhcharoption">
			<?php \app\core\Html::viewTechChar($models->character);?>
		</div>
	</div>
</div>
<!--КОНЕЦ ТЕХНИЧЕСКИЕ ХАРАКТЕРИСТИКИ-->

<!--КОМПЛЕКТАЦИИ-->
<br><br><br>
<div class="container  hidden-xs" >
	<div class="row" >
		<div class="col-sm-9" style="padding-left:0px;">
		    <div  id="buttonV" class="col-sm-3 col-md-2 complectButton complectDostyp buttonmodelON" data-form='complect_vse' cheked='true' 
		    style=" "

		    >
		    	<a class="button button-white " >Все типы<i id="indicatV" class="fa fa-angle-right"></i></a>
		    </div>
		    <div style="" id="buttonM" class="col-sm-3 col-md-2 complectButton complectDostyp disainClac buttonmodelOF" data-form='complect_m' cheked='false'>
		    	<a class="button button-white " >Механика<i id="indicatM" class="fa fa-angle-right"></i></a>
		    </div>
		    <div style="" id="buttonC" class="col-sm-3 col-md-2 complectButton complectDostyp disainClac buttonmodelOF" data-form='complect_c' cheked='false'>
		    <a class="button button-white " >Вариатор<i id="indicatC" class="fa fa-angle-right"></i></a>
		    </div>
		    <div style="" id="buttonA" class="col-sm-3 col-md-2 complectButton complectDostyp disainClac buttonmodelOF" data-form='complect_a' cheked='false'>
		    <a class="button button-white" >Автомат<i id="indicatA" class=" fa fa-angle-right"></i></a>
		    </div>
		    <!--div style="border-bottom: 2px solid #dfdfdf; padding-top: 24px;height: 52px;" class="col-sm-2" >
		    
		    </div-->
		</div>
		
		<div class="col-sm-3" style="padding-right:0px;">
		    <div style=" padding-top: 11px; padding-right:0px;" id='gruppa' class="col-sm-12 complectButton complectDostyp" data-form='complect_g' cheked-g='false' style="">
		    <a class="button button-seryi "  ><span id="gruppirovka"> Группировать</span><i id="grupirov" class="fa fa fa-object-group"></i></a>
		    </div>
		</div>
	</div>
	</div>
	
<div class="container" id="compl" style="margin-top: 0px;margin-bottom: 30px; ">
<!--?php \app\core\Html::prA($models);?-->

	

<script>
//МАССИВЫ С МОДЕЛЯМИ
	var models = [];
	var allo = [];
	var savemas=[];
	var datchik=[];

	
	$(document).ready(function(){
		//ДАТЧИКИ
		var complect_m=0;
		var complect_a=0;
		var complect_c=0;
		var complect_sum=0;
		var chek=0;
		
		
		$('.complect1').each(
			function(element, index) {
		   		if($(this).attr('data-transmission').substr(0, 1)=='М'){
		   			complect_m=1;
		   		} else if ($(this).attr('data-transmission').substr(0, 1)=='А'){
		   			complect_a=1;
		   		} else if ($(this).attr('data-transmission').substr(0, 1)=='C'){
		   			complect_c=1;
		   		}		 			
		   				

		   	}
		);	

		//сКРЫТЬ ПОКАЗАТЬ КНОПКИ ПРИ НАЛИЧИИ ВАРИАТОР МЕХАНИК АВТОМАТ
	   	complect_sum=complect_m+complect_a+complect_c;
            
        $('.complectButton').each(
			function(element, index) {
		  		if(complect_m==0 && $(this).attr('data-form')=='complect_m' ||$(this).attr('data-form')=='complect_m'&& complect_sum==1)
		  			{$(this).remove();
		   		
		   		} else if (complect_a==0 && $(this).attr('data-form')=='complect_a' || complect_sum==1&& $(this).attr('data-form')=='complect_a')
		   			{$(this).remove();
		   		
		   		} else if (complect_c==0 && $(this).attr('data-form')=='complect_c' || complect_sum==1&& $(this).attr('data-form')=='complect_c')
		   			{$(this).remove();
		   		} else if (complect_sum==0 && $(this).attr('data-form')=='complect_vse')
		   			{$(this).remove();
		   		}

		   	}
		);
        //ПОДГОТОВКА МАССИВОВ
		$('.complect1').each(
			function(index, element) {
		   		models[index]=this;
		   		savemas[index]=this;

		    }
		);
		models=models.sort(CompareForSort);
		allo=models.slice();

		// Сортировка обекта.
		function CompareForSort(first, second){
			if (first.getAttribute("data-sort") == second.getAttribute("data-sort"))
				return 0;
			if (first.getAttribute("data-sort") < second.getAttribute("data-sort"))
			    return -1;
			else
			    return 1; 
		}

		var razdelitel; 
		
		

		for (var daf = 0; daf < allo.length; daf++) {
  			

  			if(daf>0){

  				if(allo[daf].getAttribute("data-transmission").substr(0, 1)!=
  			   allo[daf-1].getAttribute("data-transmission").substr(0, 1))
  			{
  				//datchik=datchik+1;
  			}



  				if(allo[daf].getAttribute("data-sort")!=allo[daf-1].getAttribute("data-sort")){
  					
  					razdelitel= document.createElement('div');
  					razdelitel.setAttribute('data-transmission', 'Н')
  					razdelitel.setAttribute('data-razd', 'Н')
					razdelitel.className = "complect1 row razdelitel";
					razdelitel.innerHTML = '<h3 style="color:#000;">Двигатель '+allo[daf].getAttribute("data-size")+' л. '+allo[daf].getAttribute("data-power") +' л.с.'+'<span></h3>';
  					models.splice(daf+chek,0,razdelitel);
  					
  					chek =chek+1;
  					datchik[chek]=daf+chek-1;
				}
			} else{
				razdelitel= document.createElement('div');
				razdelitel.className = "complect1 row razdelitel";
				razdelitel.setAttribute('data-razd', 'Н')
				razdelitel.setAttribute('data-transmission', 'Н')
				razdelitel.innerHTML = '<h3 style="color:#000;">Двигатель '+allo[daf].getAttribute("data-size")+' л. '+allo[daf].getAttribute("data-power") +' л.с.'+'<span></h3>';
				models.splice(daf+chek,0,razdelitel);
  				chek =chek+1;
  				datchik[chek]=daf+chek-1;

			}			
  					
  	    }	
  	    var komi=1;
		datchik[chek+1]= models.length; 	    
		
  	     	    

	});


		$('.complectButton').click(function(){
		  
		    	var z=0;
		    	var x=0;
		    	var cont = $('#compl')
		    	var complectButton=$(this).attr('data-form');
		   		var complectButtonG=$(this).attr('cheked-g');

		   		//ВПИСЫВАЕМ СГРУПИРОВАННЫЙ МАССИВ			
		   		if(complectButton=='complect_g'){
		   			
		   			var olga;
		   			
		   			/*if(complectButtonG=='true'){
		   				$('.razdelitel').each(
		   				function(index, element) {
		   					$(this).css("display", "none");
		   				})
		   			} else {


		   				$('.razdelitel').each(
		   				function(index, element) {
		   							
		   						//$(this).css("display", "block");
		   					
		   				})

		   			}*/


					if($(this).attr('cheked-g')=='false'){
						

						//console.log("/");

						for (var z = 0; z < models.length; z++) {
							//console.log(models[z]);
  							cont.append(models[z]);
  						}
  					  this.setAttribute('cheked-g', 'true');
  					  $("#gruppirovka").text("Разгрупировать");
  					  $("#grupirov").removeClass("fa-object-group").addClass("fa-object-ungroup");
  					  grupirov
  					}else{
  						//cont.remove();
  						$('.razdelitel').each(
			   						function(index, element) {
			   							$(this).remove();
			   					})
  						for (var x = 0; x < savemas.length; x++) {
  							
  							cont.append(savemas[x]);
  						}
  						this.setAttribute('cheked-g', 'false');
  						$("#gruppirovka").text("Групировать");
  						$("#grupirov").removeClass("fa-object-ungroup").addClass("fa-object-group");
  					}
  				}


		   		$('.complect1').each(
		   			function(index, element) {
		   				
		   					   				
		   				if (complectButton=='complect_m'){


		   					$("#buttonV").attr("cheked","false");
		   					$("#buttonM").attr('cheked','true');
		   					$("#buttonC").attr('cheked','false');
		   					$("#buttonA").attr('cheked','false');

		   					$("#buttonM").removeClass("buttonmodelOF").addClass("buttonmodelON");
		   					$("#buttonA").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonC").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonV").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					
		   					$("#indicatM").removeClass("fa-angle-right").addClass("fa-angle-down");
		   					$("#indicatA").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatC").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatV").removeClass("fa-angle-down").addClass("fa-angle-right");

		   					//childNodes[0]

		   					if($(this).attr('data-transmission').substr(0, 1)!='М'){
		   						if($(this).attr('data-transmission').substr(0, 1)!='Н'){
		   							$(this).css("display", "none");
		   							$('.razdelitel').each(
						   				function(index, element) {
						   					$(this).css("display", "none");
						   				})
		   							
		   						}
		   					} else {$(this).css("display", "block");}
		   					if($('#gruppa').attr('cheked-g')=='false'){
			   					$('.razdelitel').each(
			   						function(index, element) {
			   							$(this).css("display", "none");
			   					})
							}

		   				} else if(complectButton=='complect_a'){
		   					$("#buttonV").attr("cheked","false");
		   					$("#buttonM").attr('cheked','false');
		   					$("#buttonC").attr('cheked','false');
		   					$("#buttonA").attr('cheked','true');
		   					
		   					$("#buttonA").removeClass("buttonmodelOF").addClass("buttonmodelON");
		   					$("#buttonM").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonC").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonV").removeClass("buttonmodelON").addClass("buttonmodelOF");

		   					$("#indicatA").removeClass("fa-angle-right").addClass("fa-angle-down");
		   					$("#indicatM").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatC").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatV").removeClass("fa-angle-down").addClass("fa-angle-right");


		   					if($(this).attr('data-transmission').substr(0, 1)!='А'){
		   						if($(this).attr('data-transmission').substr(0, 1)!='Н'){
		   							$(this).css("display", "none");
		   						}
		   					} else {$(this).css("display", "block");}
		   					if($('#gruppa').attr('cheked-g')=='false'){
			   					$('.razdelitel').each(
			   						function(index, element) {
			   							$(this).css("display", "none");
			   					})
							}

		   				} else if(complectButton=='complect_c'){
		   					$("#buttonV").attr("cheked","false");
		   					$("#buttonM").attr('cheked','false');
		   					$("#buttonC").attr('cheked','true');
		   					$("#buttonA").attr('cheked','false');


		   					$("#buttonC").removeClass("buttonmodelOF").addClass("buttonmodelON");
		   					$("#buttonM").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonV").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonA").removeClass("buttonmodelON").addClass("buttonmodelOF");

		   					$("#indicatC").removeClass("fa-angle-right").addClass("fa-angle-down");
		   					$("#indicatM").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatA").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatV").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					
		   					if($(this).attr('data-transmission').substr(0, 1)!='C'){
		   						if($(this).attr('data-transmission').substr(0, 1)!='Н'){
		   							$(this).css("display", "none");
		   						}
		   					} else {$(this).css("display", "block");}
		   					if($('#gruppa').attr('cheked-g')=='false'){
			   					$('.razdelitel').each(
			   						function(index, element) {
			   							$(this).css("display", "none");
			   					})
							}

		   				} else if(complectButton=='complect_vse'){
		   					$("#buttonV").attr("cheked","true");
		   					$("#buttonM").attr('cheked','false');
		   					$("#buttonC").attr('cheked','false');
		   					$("#buttonA").attr('cheked','false');

		   					$("#buttonV").removeClass("buttonmodelOF").addClass("buttonmodelON");
		   					$("#buttonM").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonC").removeClass("buttonmodelON").addClass("buttonmodelOF");
		   					$("#buttonA").removeClass("buttonmodelON").addClass("buttonmodelOF");

		   					$("#indicatV").removeClass("fa-angle-right").addClass("fa-angle-down");
		   					$("#indicatM").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatC").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					$("#indicatA").removeClass("fa-angle-down").addClass("fa-angle-right");
		   					
		   					if($(this).attr('data-transmission').substr(0, 1)!='Н'){
		   					$(this).css("display", "block");	}
		   					if($('#gruppa').attr('cheked-g')=='false'){
			   					$('.razdelitel').each(
			   						function(index, element) {
			   							$(this).css("display", "none");
			   					})
							}

		   				} else if(complectButton=='complect_g'){
		   					

		   					if(complectButtonG=='false'){
			   					$('.complectDostyp').each(
			   					function(index, element) {
			   						if($(this).attr("cheked")=='true'){
			   						
			   							olga=$(this).attr("id");	 	
			   						}
			   					})
			   					if(olga=="buttonV"){
			   						$(this).css("display", "block")
			   					}
			   					else if(olga=="buttonM"){
			   						if($(this).attr('data-transmission').substr(0, 1)!='М'){

										$(this).css("display", "none")
									} else{$(this).css("display", "block")}


			   					}
			   					else if(olga=="buttonA"){
			   						if($(this).attr('data-transmission').substr(0, 1)!='А'){

										$(this).css("display", "none")
									} else{$(this).css("display", "block")}


			   					}
			   					else if(olga=="buttonC"){
			   						if($(this).attr('data-transmission').substr(0, 1)!='C'){

										$(this).css("display", "none")
									} else{$(this).css("display", "block")}


			   					}

							} else {
								$('.razdelitel').each(
			   						function(index, element) {
			   							$(this).css("display", "none");
			   					})
							}
		   					
		   					//$(this).css("display", "none");	

		   				}

		   				
		   				
		   		});
		   	 	

				

//console.log(models[0]);
		   		//models.sort(function(){return models. - b});
		   		//console.log(models[index].getAttribute("data-power"));

		   				   				//console.log(datchik.length+"----");

		   	for (var y = 1; y < datchik.length-1; y++){
		   		
			var chit =0;
			if(y!=datchik.length-1){
				//console.log(datchik[y]+"++++");
				//	console.log(datchik[y+1]+"//////");
				for (var v = datchik[y]+1; v < datchik[y+1]; v++) {
  					if(typeof models[v].style.display && models[v].style.display=='block') {
  						chit++

  					};
  					
  				}
  				
  			
  				

  			//console.log("---------");
  			//console.log(datchik[y]);
  			}
  			if(typeof models[datchik[y]]){
  			
  			if(chit>0 ){	
  				//console.log(chit+'|||||||||');
  				models[datchik[y]].style.display='block';
  			} else{models[datchik[y]].style.display='none';}
		}
	}

		   	});
			$('.disainClac').click(function(){


			});
			
		    </script>
	<?php ?>
<?php if(is_array($models->complect)) :
	$i=0;

	foreach ($models->complect as $key => $complect) : ?>

	<div class="row complect1" 
		data-transmission="<?=$complect->motor->transmission;?>" 
		data-power="<?=$complect->motor->power;?>"
		data-size="<?=$complect->motor->size;?>"
		data-sort="<?=$complect->motor->size+$complect->motor->power;?>"
	>
		
		<!--БЛОК НАЗВАНИЕ КОМПЛЕКТАЦИЯ (КНОПКА РАЗВЕРТЫВАНИЯ)-->
		<div style="float:left;width:100%;border-bottom: 1px solid #dfdfdf; z-index:100;" class="open_complect" data-role="1">
			<div class="col-sm-8 col-xs-10 hidden-xs" style="padding-right:0px;">
				<h3 class="complect-name-link" >
					<?=$complect->name;?> <?= $complect->motor->getMotorForUser($models->type);?> 
					<small class="smallcount" >
						
						<span class="hidden-xs">(<?=$complect->code;?>)</span>
						<?php if(\app\models\car_available::getCountComplect($complect->id)!=0) : ?>

						<a 
							class="totalcars-block-open hidden-xs" 
							data-role="1" 
							style=""> 
							<span class="hidden-xs">есть </span><?=\app\models\car_available::getCountComplect($complect->id);?><span class="hidden-xs"> а/м</span>
						</a>

						<?php endif;?>
					</small>
				</h3>
			</div>

			<div class="col-sm-4 col-xs-2 hidden-xs" style="padding-left: 0px;" >
				<h3 class="complect-name-link text-right">
					<span class="hidden-xs" style="padding-right:8px;">от <?= number_format($complect->price,0,'',' ');?> руб.</span>
					<a data-role="1" class="open_complect"><i class='fa fa-angle-down'></i></a>
				</h3>
			</div>

			<!--Страница модели версия для мобильных-->
			<div class="visible-xs" style="width: 90%; float: left; padding-left: 15px;">
				
				<h3 class="complect-name-link" style="float: left;">
					<?=$complect->name;?> <?= $complect->motor->getMotorForUser($models->type);?> 
				</h3>
				<?php if(\app\models\car_available::getCountComplect($complect->id)!=0) : ?>
					<span class="number-circle-right-model visible-xs" style="float: left; margin: 9px 0px 0px 4px; font-size: 10px;"><?=\app\models\car_available::getCountComplect($complect->id);?></span>
				<?php endif;?>
			</div>
			<div class="visible-xs" style="width: 10%; position: inline-block; float: right; padding-right: 15px;" >
				<h3 class="complect-name-link text-right">
					<span class="hidden-xs" style="padding-right:8px;">от <?= number_format($complect->price,0,'',' ');?> руб.</span>
					<a data-role="1" class="open_complect"><i class='fa fa-angle-down'></i></a>
				</h3>
			</div>
			<!--ENDСтраница модели версия для мобильных -->
		</div>
		<!--БЛОК НАЗВАНИЕ КОМПЛЕКТАЦИЯ (КНОПКА РАЗВЕРТЫВАНИЯ)-->

		<div class="complect-hidden col-sm-12 " style="float:left;padding:0px;width: 100%;">
			<!--BEGIN BLOCK AVAILABLE CAR-->
			<div class="" style="padding:0px;width:100%;">
				<div class="col-sm-12 avacarblock" style="padding:0px;" id="available-car"  >
					<?php if(is_array($complect->cars)) : ?>
						<?php foreach($complect->cars as $obj) : ?>
							<?php $obj->complect = $complect;?>
							<?php \app\models\car_available::getCarForList($obj,$models,$complect,$complect->motor);?>			
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<!--END BLOCK AVAILABLE CAR-->

			
			<div class='specification col-sm-12' style="float: left;">
				<div class="col-sm-4 hidden-xs">

					<!--BEGIN TECH CHARACTER-->
					<?php \app\core\Html::viewAgregat(
						$complect->motor,
						$complect->code
					);?>
					<!--END TECH CHARACTER-->

					<?php if(!empty($complect->option)) : ?>
						<?php $countOption = (int)((count($complect->option)-5) / 2);?>
						<ul class="option-list" >
							<li><b>Комплектация <?=$complect->name;?></b></li>
							<?php for ($i=0;$i<$countOption;$i++) : ?>
								<li class="text-left"><?= $complect->option[$i]->name;?></li>
							<?php endfor; ?>
						</ul>
					<?php endif;?>
				</div>
				<div class="col-sm-4 hidden-xs" >
					<!--BEGIN OPTION-->
					<ul class="option-list" >
						<?php for ($i=$countOption;$i<count($complect->option);$i++) : ?>
							<li class="text-left"><?= $complect->option[$i]->name;?></li>
						<?php endfor; ?>
						<div style="border-top:1px dashed #ccc"></div>
					</ul>
					<!--END OPTION-->
					
					<!--BEGIN BLOCK COMPLECT PRICE-->
					<div class="pack-price" style="width: 100%;" >
						<div style="padding-right: 5px;" class="col-sm-12 text-right">
							<?= number_format($complect->price,0,'',' ');?> руб.
						</div>
					</div>
					<!--END BLOCK COMPLECT PRICE-->
				</div>



				<div class="visible-xs col-xs-12">
					<!--BEGIN TECH CHARACTER-->
					<?php \app\core\Html::viewAgregat(
						$complect->motor,
						$complect->code
					);?>
					<!--END TECH CHARACTER-->
				</div>

				<!--BEGIN SMALL DISPLAY-->
				<div class="visible-xs col-xs-12" style="float: left;" >
					<span class="click-option-complect" style="">
						<b>Комплектация <?=$complect->name;?></b>
						<span style="" class="fa">подробнее</span>
					</span>
					<ul class="option-list option-list-disabled">
						<?php foreach($complect->option as $option) : ?>
							<li class="text-left"><?= $option->name;?></li>
						<?php endforeach; ?>
						
					</ul>
					<div style="width:100%;border-top:1px dashed #ccc"></div>
					<div class="clearfix"></div>
					<!--BEGIN BLOCK COMPLECT PRICE-->
					<div class="pack-price" >
						<div style="" class=" text-right">
							<?= number_format($complect->price,0,'',' ');?> руб.
						</div>
					</div>
					<!--END BLOCK COMPLECT PRICE-->
				</div>
				<!--END SMALL DISPLAY-->

				<div class="col-sm-4 col-xs-12" style="float: left;">
					<!--BEGIN DOP PACKEG-->
					<div class="dop-option-block"  >
					<?php if(is_array($complect->packs)) : ?>
						<div class="pack-list text-left">
							<b>Опционное оборудование</b>
						</div>
						<?php foreach ($complect->packs as $key => $pack) : ?>
							<div class="pack-list">
								<?= $pack->name;?>
							
							</div>
							<div class="pack-list text-left">
								<?= $pack->option_list;?>
							</div>
							<div class="pack-price text-right" style="position: relative;">
								<div style="border-top:1px dashed #ccc"></div>
								<p> <span style="font-size: 14px; color: #8c8c8c; position: absolute; left: 0;"><?= $pack->code;?></span> <?=number_format($pack->price,0,'',' ');?> руб.</p>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
					</div>
					<!--END DOP PACKEGE-->
				</div>
			</div>
			<!-- BEGIN BLOCK BUTTON COMPLECT-->
			
			<div class="col-sm-12 text-right " style=" padding: 15px 0;float: left;width: 100%;">
					<!--a class="button-quest">Не стесняйся задать вопрос </a--> 
					<!--span style="font-size: 18px;margin-right: 10px;">или</span--> 
					<div class="col-sm-4 hidden-xs" style="">
						<?php \app\core\Html::modalQuestion();?>
					</div>

					<div class="col-sm-4 hidden-xs" style="">
						<?php \app\core\Html::modalTest();?>
					</div>

					<div class="col-sm-4 " style="">
						<?php if(\app\models\car_available::getCountComplect($complect->id)>0) : ?>
							<a href="/content/configure/<?=$models->link;?>/<?=$complect->id;?>/<?=strtolower($complect->name);?>" class="button button-black" style="margin-right: 0px;" >
								Использовать конфигуратор
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</a>
						<?php else : ?>
							<a href="/content/configure/<?=$models->link;?>/<?=$complect->id;?>/<?=strtolower($complect->name);?>" class="button button-black" style="margin-right: 0px;" >
								Заказать такой автомобиль
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</a>
						<?php endif;?>
					</div>
			</div>
			<!--END BLOCK BUTTON COMPLECT-->
		</div>
	</div>
		
	<?php endforeach; ?>
<?php endif; ?>
</div>
<!--КОНЕЦ КОМПЛЕКТАЦИИ-->

<!--TEST DRIVE VIDGET BEGIN-->
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

<!--KREDIT PROGRAM BEGIN-->
<?php if(is_array($kredit)) : ?>
	<?php 
		\app\core\PageElements::getKreditCarousel(
			$kredit,
			$models,
			"",
			""
		);
	?>
<?php endif;?>
<!--KREDIT PROGRAM END-->

<!-- Модаль -->  
<div class="modal fade get-link" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h1 class="modal-title" id="myModalLabel"><img style="width:60px; padding-right: 10px;" src="/images/user.jpg"/><b>Скачайте файлы</b></h1>
      </div>
      <div class="modal-body">
        <form class="modal-form" id="getmodalform">
        	<input type="text" name="name" placeholder="Ваше имя"/>
        	<input type="text" name="phone" placeholder="Ваш телефон"/>
        	<input type="text" name="mail" placeholder="Ваш email (не обязательно)"/>
        	<input type="hidden" name="car" value="<?=$models->name;?>">
        	<div class="personal-check text-left">
        		<input type="checkbox" name="valid" id="valid-input" style="width: auto;">
        		<label for="valid-input">Даю согласие на обработку своих персональных данных</label>
        	</div>
        	<button type="button" id="getLinkButton" class="button button-gray" style="pointer-events: none;">
        		Получить ссылку
        		<i class="fa fa-chevron-right"></i>
        	</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if((isset($data['info'])) && ($data['info']!=false)) { ?>
	<!--БЛОК АВТОМОБИЛИЙ INFO-->
	<div class="container-fluid info-car">
    <div class="container block avto-vnature ">
		<div class="row">
			<div class="row">
				<div class="autoplay">
				  <?php foreach ($data['info'] as $obj) {
				  ?>
				  	<div style="padding-left: 15px; padding-right: 15px; ">
						<h3><?= $obj->getTitle();?></h3>
						<img class="for-view" src="/images/aboutcar/<?=$obj->getImg();?>">
						<p class="text-justify text"><?= $obj->getText();?></p>
						<p class="facts"><?= $obj->getFacts();?></p>
						<p><b><?= $obj->getConclusion();?></b></p>
					</div>
				  <?php
				  	}
				  ?>
				</div>
			</div>
		</div>
	</div>
    </div>
    <!--КОНЕЦ БЛОКА-->
<?php } ?>

<!--BLOCK PHOTO-->
<?php if(!empty($models->pictures)) : ?>
<div class=" container " style="padding-bottom: 0px;">
	<div id="mygallery" >
	<?php foreach($models->pictures as $img) : ?>

			<a href="<?=$img;?>" data-lightbox="image-1">
		        <img alt=" <?=$models->brand->name.' '.$models->name;?>" src="<?=$img;?>"/>
		    </a>
		
	<?php endforeach;?>
	</div>
</div>
<?php endif;?>
<!--END PHOTOBLOCK-->

<!--ФОРМЫ-->
</div>
<?php if(isset($data['form'])) : ?>
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

<div class="container-fluid  hidden-xs" style="" id="animate-block">
	<div class="container" style="padding:0px;">
		<div class="row">
			<div class="block-title" id="scrollanimation">
				<a id="question"></a>
				ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
			</div>
			<div class="col-sm-12 text-center" style="font-size: 20px; ">
				Мы рады, что Вас заинтересовал <?=$models->label.' '.$models->brand->name.' '.$models->name;?>. 
				Дополнительную информацию о выбранном автомобиле Вы можете 
				получить по телефону отдела продаж 8 (8212) 288 588 или задайте вопрос в форме ниже. Наши сотрудники свяжутся с Вами и постараются ответить на все вопросы.
			</div>
			

			<div class="col-sm-8 col-sm-offset-2" id="">
				<?php foreach ($data['form'] as $key => $form) : ?>
					<div class="  " id="">
						<?=$form->html;?>
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->

<script>
	$(document).ready(function(){
		$("#available-car-id").click(function(){
			var id = $(this).attr("data-tab-car");
			$("#form-tab-car input").val(id);
			$("#form-tab-car").submit();
		})
	})
</script>

<form action="/available/viewlist" method="POST" id='form-tab-car'>
	<input type="hidden" value="" name="model">
</form>

