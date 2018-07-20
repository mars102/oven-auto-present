<style>
  .blur{
    filter:blur(5px) ;
  }
</style>
<input type="hidden" form="userModal" value="<?=$model->complect->id;?>" name="id_complect" >

<div class="container block" style="padding-bottom: 0px;">
  <div class="col-sm-12" style="padding:0px;">

    <!--BLOCK CAR ALPHA-->
    <div class=" " style=" ">
    <a id="colorlist"></a>
    <div class="col-sm-6 col-sm-offset-3" style="padding:0px;">
      <div class="blur" >
        <img class="present a " src="http://admin.oven-auto.ru<?=$model->alpha;?>" style="z-index: 1; width: 100%;"/>
        <?php if($model->name=='Kaptur') : ?>
            <img  class="present w " src="http://admin.oven-auto.ru/content/cars/39/w.png" style="z-index: 1; width: 100%; display: none;"/>
            <img  class="present b " src="http://admin.oven-auto.ru/content/cars/39/b.png" style="z-index: 1; width: 100%; display: none;"/>
          <?php endif;?>
      </div>
      <div class="color-block text-center" style="">
        
        <?php
                $button_1 = "";
                $button_2 = "";
                $button_3 = "";
            ?>
            <?php foreach ($model->palette as $color) :?>
              
                <?php 
                $val = "a";
                $pay_color="";

                $search = ','.$color->id.',';
                $string = $model->pay_color;
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
                        ' data-double = "true" '.
                        ' style="background: '.$background.'"'.
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
                        ' data-double = "true" '.
                        ' data-type="'.$val.'"'.
                        ' style="background: '.$background.'"'.
                        ' pay-color = "'.$pay_color.'" >'.
                    '</div>';
                    }
                  }
                  else{
                    $button_2 .= '
                      <div'.
                        ' class="color-button"'.
                        'data-color-name="'.$color->name.' ('.$color->rn_code.')"'.
                        'data-color="'.$data_color.'"'.
                        'data-type="'.$val.'"'.
                        'style="background: '.$background.'"'.
                        'pay-color = "'.$pay_color.'">'.
                    '</div>';
                  }
                ?>
              
            <?php endforeach;?>
        
        <?=$button_2;?><br/><?=$button_3;?><br/><?=$button_1;?>

        <div class="noncolor car-color-name" style="padding-bottom:15px;">Выберите цвет<br/>&nbsp</div>
        <div id="text-color" style="display:none;" class="car-color-name"></div>

      </div>
    </div>
    </div>
    <!--END CAR ALPHA-->
  </div>
</div>



<div class="container block configure">

  <div class="row">

    <?php 
      \app\core\Html::carHead(
        $model->complect->motor->getMotorForUser(),
        'Конфигуратор',
        $model->name,
        $model->complect->name,
        $model->complect->price
      );
    ?>

    <div class="col-sm-4 hidden-xs">
      <!--AGREGAT-->
      <?php \app\core\Html::viewAgregat($model->complect->motor,$model->complect->code);?>
      <!--END AGREGAT-->
      <?php if(!empty($model->complect->option)) : ?>
        <?php $countOption = (int)(((count($model->complect->option))-5) / 2);?>
        <ul class="option-list" >
          <li><b>Комплектация <?=$model->complect->name;?></b></li>
          <?php for ($i=0;$i<$countOption;$i++) : ?>
            <li class="text-left"><?= $model->complect->option[$i]->name;?></li>
          <?php endfor; ?>
        </ul>
      <?php endif;?>
    </div>

    <div class="col-sm-4 hidden-xs">
      <!--BEGIN OPTION-->
      <ul class="option-list" >
        <?php for ($i=$countOption;$i<count($model->complect->option);$i++) : ?>
          <li class="text-left"><?= $model->complect->option[$i]->name;?></li>
        <?php endfor; ?>
        <div style="border-top:1px dashed #ccc"></div>
      </ul>
      <!--END OPTION-->
      <!--BEGIN BLOCK COMPLECT PRICE-->
      <div class="pack-price" >
        <!--div style="padding-left: 5px;" class="col-sm-5 text-left"></div-->
        <div style="padding-right: 5px;" class="col-sm-12 text-right">
          <?= number_format($model->complect->price,0,'',' ');?> руб.
        </div>
      </div>
    </div>

    <div class="visible-xs col-xs-12">
			<!--BEGIN TECH CHARACTER-->
			<?php \app\core\Html::viewAgregat(
				$model->complect->motor,
				$model->complect->code
			);?>
			<!--END TECH CHARACTER-->
		</div>
    
    <!--BEGIN SMALL DISPLAY-->
    <div class="visible-xs col-xs-12" >
      <span class="click-option-complect">
        <b>Комплектация <?=$model->complect->name;?></b>
        <span style="" class="fa">подробнее</span>
      </span>
      <ul class="option-list option-list-disabled">
        <?php foreach($model->complect->option as $option) : ?>
          <li class="text-left"><?= $option->name;?></li>
        <?php endforeach; ?>
        
      </ul>
      <div style="border-top:1px dashed #ccc"></div>
      <!--BEGIN BLOCK COMPLECT PRICE-->
      <div class="pack-price" >
        <!--div style="padding-left: 5px;" class="col-sm-5 text-left"></div-->
        <div style="padding-right: 5px;" class="col-sm-12 text-right">
          <?= number_format($model->complect->price,0,'',' ');?> руб.
        </div>
      </div>
      <!--END BLOCK COMPLECT PRICE-->
    </div>
    <!--END SMALL DISPLAY-->

    <div class="col-sm-4" style="float: left;">
        <?php if(is_array($model->complect->packs)) : ?>
        <div class="dop-option-block" >
          <div><b>Выберите опционное оборудование</b></div>
          
          <div class="pack-list color-visible" style="font-weight: normal;">
            <span id="current-code"></span>, <span id="current-color"></span><span id="current-type" ></span>
          </div>
              
          <div style="border-top:1px solid #fc3"></div>

          <div class="pack-list text-left" style="padding-bottom: 30px;padding-top: 3px;">
            
            <span id="current-view-color" style="border:1px solid #bbb;width: 20px;height: 20px; border-radius: 100%; display: inline-block;float: right;"></span>
            <a style="float: left; padding: 0;" href="#colorlist" class="scrollto">Изменить цвет</a>
          </div>

          <?php foreach ($model->complect->packs as $key => $pack) : ?>
            <?php 
              $check = "";
              $znak = "+";
              if(in_array($pack->id,$install_pack))
              {
                $check = "checked";
                $znak = '-';
              }
            ?>
            <?php if (strripos($pack->option_list, 'металлик') !== false) :?>

              <div class=""><?=$pack->name;?></div>
              <div class="pack-list text-left"><?=$pack->option_list;?></div>
              <div style="border-top:1px dashed #ccc"></div>
              <div class="pack-price text-right " style="">
                <p style="text-align: left;">
                  <input 
                    <?=$check;?>
                    value="<?=$pack->id;?>" 
                    type="checkbox" 
                    name="packs[]" 
                    class="checkbox " 
                    id="checkbox<?=$pack->id;?>" 
                    data-znak='<?=$znak;?>' 
                    data-price="<?=$pack->price;?>"
                    form = "userModal"
                  >
                  <label style="display: inline;" for="checkbox<?=$pack->id;?>"></label>
                  <span style="float: right;"><?=number_format($pack->price,0,'',' ');?> руб.</span>
                </p>
              </div>
              
              <?php unset($model->complect->packs[$key]);?>

            <?php endif;?>

            <?php if (strripos($pack->option_list, 'двухцветная') !== false) :?>

              <div class=""><?=$pack->name;?></div>
              <div class="pack-list text-left"><?=$pack->option_list;?></div>
              <div style="border-top:1px dashed #ccc"></div>
              <div class="pack-price text-right " style="">
                <p style="text-align: left;">
                  <input 
                    <?=$check;?>
                    value="<?=$pack->id;?>" 
                    type="checkbox" 
                    name="packs[]" 
                    class="checkbox " 
                    id="checkbox<?=$pack->id;?>" 
                    data-znak='<?=$znak;?>'
                    data-price="<?=$pack->price;?>"
                    form = "userModal"
                  >
                  <label style="display: inline;" for="checkbox<?=$pack->id;?>"></label>
                  <span style="float: right;"><?=number_format($pack->price,0,'',' ');?> руб.</span>
                </p>
              </div>
              
              <?php unset($model->complect->packs[$key]);?>

            <?php endif;?>
          
          <?php endforeach;?>

          <?php foreach ($model->complect->packs as $pack) : ?>
            <?php 
              $check = "";
              $znak = "+";
              if(in_array($pack->id,$install_pack))
              {
                $check = "checked";
                $znak = '-';
              }
            ?>
            
              <div class=""><?=$pack->name;?></div>
              <div class="pack-list text-left"><?=$pack->option_list;?></div>
              <div style="border-top:1px dashed #ccc"></div>
              <div class="pack-price text-right " style="">
                <p style="text-align: left;">
                  <input 
                    <?=$check;?>
                    value="<?=$pack->id;?>" 
                    type="checkbox" 
                    name="packs[]" 
                    class="checkbox " 
                    id="checkbox<?=$pack->id;?>" 
                    data-znak='<?=$znak;?>' 
                    data-price="<?=$pack->price;?>"
                    form = "userModal"
                  >
                  <label style="display: inline;" for="checkbox<?=$pack->id;?>"></label>
                  <span style="float: right;"><?=number_format($pack->price,0,'',' ');?> руб.</span>
                </p>
              </div>
          <?php endforeach; ?>
        </div>
        <?php endif;?>
    </div>
  </div>
</div>


<!--BEGIN PRICESTOCK BLOCK-->
  <?=
    \app\core\PageElements::vidgetPriceStock(
      $model->name
    );
  ?>
<!--END PRICEBLOCK BLOCK-->

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


<!--KREDIT PROGRAMM BEGIN-->
<?php if(is_array($kredit)) : ?>
	<?php 
		\app\core\PageElements::getKreditCarousel(
			$kredit,
			$model,
			"",
			""
		);
	?>
<?php endif;?>
<!--KREDIT PROGRAMM END-->



<!--FORM BEGIN-->
<?php if(is_array($form)) : ?>
  <div class="container-fluid " style="" id="animate-block">
    <div class="container" style="padding:0px;">
      <div class="row">
        <div class="block-title">
          ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
        </div>
        <div class="col-sm-12 text-center " style="font-size: 20px;">
          Мы рады, что Вас заинтересовал Renault <?=$model->name.' в комплектации '.$model->complect->name;?>. Дополнительную информацию о выбранном автомобили Вы можете получить по телефону отдела продаж 8 (8212) 288 588 или задайте вопрос в форме ниже. Наши сотрудники свяжутся с Вами и постараются ответить на все вопросы.
        </div>

        <div class="col-sm-8 col-sm-offset-2" >
          <?php foreach ($data['form'] as $key => $form) : ?>
            <div >
              <?=$form->html;?>
              <input type="hidden" form="fcb<?=$form->id;?>" value="<?=$model->name;?>" name="model" >
              <input type="hidden" form="fcb<?=$form->id;?>" value="<?=$model->complect->id;?>" name="complect" >
              <input type="hidden" form="fcb<?=$form->id;?>" value="none" name="color" >
              <input type="hidden" form="fcb<?=$form->id;?>" value="none" name="id_packs">
              <input type="hidden" form="fcb<?=$form->id;?>" value="<?=$model->complect->price;?>" name="totalprice">
              <input type="hidden" form="fcb<?=$form->id;?>" value="Страница конфигуратора модели - <?=$model->name;?>" name="page" >
            </div>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->



<script>
  $(".color-block button").click(function(){
    $("input[name='color']").val($(this).attr("data-color-name"));
  })
  $("input[name='packs']").click(function(){
    var data ='';
    $("input[name='packs']").each(function(){
      if($(this).prop("checked")) data += $(this).val()+',';
    })
    $('input[name="id_packs"]').val(data);
  })
</script>

<script>

  $(document).ready(function(){

    $(".ava-cars").click(function(){
      var id = $(this).attr("data-tab-car");
      $("#form-tab-car input").val(id);
      $("#form-tab-car").submit();
    });

  })
</script>

<form action="/available/viewlist" method="POST" id='form-tab-car'>
  <input type="hidden" value="" name="model">
</form>


<?php 
  $carfor = 
    
    '<span>Конфигуратор</span><br/>'.
    '<span>Привезём до '.date('d.m.Y',strtotime("+30 days")).'</span><br/>'.
		'Комплектация '.$model->complect->name.'<br/>'.
    $model->complect->motor->getMotorNameAdmin().'<br/>'.
    'Стоимость '.\app\core\Html::money($model->complect->price).' руб.'
  ;
  $carplus = 
    'Доп. оборудование 0 руб.<br/>'.
    'Скидка 0 руб.<br/>'.
    'Цена '.\app\core\Html::money($model->complect->price).' руб.'
  ;
?>

<div style="display:none" id="right-modal">
  <div class='col-sm-6 bigblack'>
    <span >Конфигуратор<br/></span>
		<span>Подготовка заказа<br/></span>
		<b>
      <?= $model->brand->name.' '.$model->name.' '.$model->complect->name;?> <br/>
      <?=$model->complect->motor->getMotorNameAdmin();?><br/>
      <span id="toppricemodal"><?=\app\core\Html::money($model->complect->price);?></span> руб.<br/>
    </b>
		<div class="dashed"></div>
		<div class="divprice">Комплектация <span style="float:right"><?=\app\core\Html::money($model->complect->price);?>руб.</span></div>
		<div class="divprice optionsmodal">Опции <span style="float:right">0 руб.</span></div>
		<div class="divprice">Доп. оборудование <span style="float:right">0 руб.</span></div>
    <div class="divprice">Скидка <span style="float:right">0 руб.</span></div>
  </div>
</div>

<script>

  var back = '#fff';
  var pic = "<?=$model->alpha;?>";
  var summa = 0; 

  $(".checkbox").each(function(index, value) { 
    if($(this).prop("checked"))
      summa+= parseInt($(this).attr("data-price"));
  });
  $(".optionsmodal span").text(summa+" руб.");
  $("#toppricemodal").html(parseInt((summa)+<?=$model->complect->price;?>)+" руб.");

  var carformodal = "<div class='col-sm-6 modal-img'><img style='filter:blur(3px);width:100%;background:"+back+"' src='http://admin.oven-auto.ru<?=$model->alpha;?>'><div class='text-center'>Цвет не выбран</div></div>";
  var carformodaltext = $("#right-modal").html(); 
  
  $(".checkbox").click(function(){
    var summa = 0;
    $(".checkbox").each(function(index, value) { 
      if($(this).prop("checked"))
        summa+= parseInt($(this).attr("data-price"));
    });
    $("#toppricemodal").text(number_format((parseInt(summa)+<?=$model->complect->price;?>),0,'',' ')+" руб.");
    $(".optionsmodal").html('Опции <span style="float:right">'+number_format(summa,0,'',' ')+' руб.</span>');
    carformodaltext = $("#right-modal").html();
  })
  $(".color-button").click(function(){
    $(".noncolor").css("display","none");
    $("#text-color").css("display","block");
    $(".blur").removeClass("blur");
    back = $(this).attr("data-color");
    if(typeof($(this).attr('data-type'))!="undefined" && $(this).attr('data-type')!="")
    {
      if($(this).attr('data-type')=='b') pic = 'http://admin.oven-auto.ru/content/cars/39/b.png';
      if($(this).attr('data-type')=='w')pic = 'http://admin.oven-auto.ru/content/cars/39/w.png';
      if($(this).attr('data-type')=='a')pic = "http://admin.oven-auto.ru<?=$model->alpha;?>";
    }
    col_name = $(this).attr("data-color-name");
    carformodal = "<div class='col-sm-6 modal-img'><img style='width:100%;background:"+back+"' src='"+pic+"'><div class='text-center'>"+col_name+"</div></div>";
  });
  
</script>