<div class="container">
    <div class="col-sm-12">
		<div class="block-title"><?=$title;?></div>
    </div>
    
    <div class="col-sm-8">
        <?=$contacts->zavod;?>

        <script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=iBDoe_EVCxr-qwJmTX-2cG__TkKSkWJf&width=100%&height=350"></script>

        <?=$contacts->address;?>
    </div>

    <div class="col-sm-4">
        <?=$contacts->contacts;?>
    </div>
</div>

<!--ФОРМЫ-->
<?php if(is_array($form)) : ?>
<div class="container-fluid " style="" id="animate-block">
	<div class="container" id="question">
		<div class="block-title">
			ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
		</div>
		<!--div class="col-sm-12 text-center" style="font-size: 20px;padding: 20px 0 ;">
			Мы рады, что Вас заинтересовал Renault <?=$car->model->name?> в комплектации <?=$car->complect->name?> 
			(VIN <span style="text-transform: uppercase;"><?=$car->vin;?></span>). 
			Дополнительную информацию о выбранном автомобиле Вы можете получить по телефону отдела продаж 8 (8212) 288 588 или задайте вопрос в форме ниже. Наши сотрудники свяжутся с Вами и постараются ответить на все вопросы.
		</div-->

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
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->