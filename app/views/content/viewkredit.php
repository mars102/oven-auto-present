<style>
	.kredit-block .car-name{
        font-size: 20px;
        font-weight:bold;
    }
</style>
<div class="container " >
	<div class="col-sm-12">
		<div class="block-title"><?=$data['title'];?></div>
	</div>
	<div class="row block text-center">

		<div class="col-sm-12 text-center" style="font-size: 20px;">
			Покупка автомобиля - значимое событие в жизни каждого человека! Собственная программа финансирования Renault Finance уже помогла многим ускорить этот счастливый момент. В рамках программы для каждого автомобиля Renault нами были разработаны специальные финансовые предложения с комфортными условиями, подобранными именно для Вас.
		</div>

	</div>
	<div class="row programm" style="border-bottom: 2px solid #fc3; padding-bottom: 20px;">
		<div class="why">
			<h2 class="text-center"><b>Как получить кредит?</b></h2>
			<h2 class="text-center">Всего 3 шага</h2>
		</div>
		<div class="col-sm-4">
			<img src="/images/kredit/1.jpg">
			<h3>Шаг 1</h3>
			<p>Получите расчет по кредиту у менеджера дилерского центра.</p>
		</div>
		<div class="col-sm-4">
			<img src="/images/kredit/2.jpg">
			<h3>Шаг 2</h3>
			<p>Оформите заявку, предъявив только паспорт и водительское удостоверение.</p>
		</div>
		<div class="col-sm-4">
			<img src="/images/kredit/3.jpg">
			<h3>Шаг 3</h3>
			<p>Подпишите кредитный договор и получите ваш новый Renault.</p>
		</div>
	</div>


	<?php if(is_array($data['kreditlist'])) : ?>
	<div class="row ">
		<div class="why">
			<h2 class="text-center"><b>Кредитные предложения</b></h2>
			<h2 class="text-center"><?=\app\core\PageElements::vidgetCurrentDate();?></h2>
		</div>

		<div style="font-size: 20px;" class="text-center">
			Наши программы финансирования помогут вам приобрести автомобиль на выгодных условиях и обеспечат качественную страховую защиту.
        </div>
        
        <?php foreach($kreditlist as $kredit) : ?>
            <div class="col-sm-12 kredit-block"  style="padding-bottom:0px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>
                            <b><?=$kredit->name;?></b>
                            <span class="srok" style="font-size:12px !important;float:right;line-height:26px;">
                                Действует до <?=date('d.m.Y',$kredit->getParam('day_out'));?>
                            </span>
                        </h2>
                    </div>
                    <div class="panel-body">
                        <h4>
                            <?php if($kredit->getParam('rate')) :?>
                                Ставка по кредиту <?=$kredit->getParam('rate');?>% |
                            <?php endif;?>

                            <?php if($kredit->getParam('pay')) :?>
                                    Ежемесячный платеж от <?=number_format($kredit->getParam('pay'),0,'',' ');?> руб. | 
                            <?php endif;?>

                            Первоначальный взнос от <?=$kredit->getParam('contribution');?>% | 

                            Срок кредита до <?=$kredit->getParam('period');?>
                            <?php 
                                if($kredit->getParam('period')<=1) echo " год";
                                else echo " лет";
                            ?>

                            <?php if($kredit->dopoption) : ?>
                                | <?=$kredit->dopoption;?>
                            <?php endif;?>
                        </h4>
                        <div class="row" style="padding-bottom:10px;padding-top:10px;">
                            <?php foreach ($kredit->model as $model) : ?>
                                <div class="col-sm-2 model-link" data-id="<?=$model->id;?>">
                                    <img style="width:100%" src="http://admin.oven-auto.ru<?=$model->icon;?>">
									<div class="car-name text-center"><?=$model->brand->name.' '.$model->name;?></div>
									<div class="text-center kredit-begin-price">от <?= number_format(\app\models\car_6_complect::minPrice($model->id),0,'',' ');?> руб.</div>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="text-justify">
                            <?=$kredit->disklamer;?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
		
    </div>
    <?php endif;?>

	<div class="row programm block text-justify" style="padding-top: 20px;">
		<div class="why">
			<h2 class="text-center"><b>Финансовые сервисы</b></h2>
		</div>
		<div class="col-sm-4">
			<img src="/images/kredit/4.jpg">
			<h3>Разумное КАСКО</h3>
			<p style="color: #000;">
				Программа имущественного страхования автомобилей марки Renault, предполагающая единый страховой тариф независимо от стажа и возраста – 3,5% в год.
			</p>
			<div class="" style="display: none; color: #555;">
				<p>
					Программа покрывает риски «Угон» и «Полная гибель» в пределах индексируемой страховой суммы сроком на 1 год; страхование риска «Ущерб» распространяется только на случаи ДТП, произошедшие с участием двух и более известных лиц по вине водителя, допущенного к управлению согласно договору страхования. Сумма страховых выплат дифференцируется в зависимости от модели автомобиля Renault, но не более 45 000 рублей (неагрегатная, 1 случай в год).
				</p>
				<p>
					Подробную информацию об условиях страхования можно получить у специалистов по финансовым услугам автосалона.
				</p>
				<p>
					Услуги страхования предоставляют ПАО СК «Росгосстрах» (лицензия СИ № 0001 от 23.05.2016 г., бессрочная), СПАО «Ингосстрах» (лицензия Банка России СИ № 0928 от 23.09.2015 без ограничения срока действия) или ООО СК «Согласие» (лицензия С№ 1307 от 25.05.2015 г., бессрочная), с полными Правилами страхования можно ознакомиться на сайтах данных организаций: ingos.ru, www.rgs.ru, www.soglasie.ru.
				</p>
			</div>
			<a class="viewkredit">Узнать больше</a>
		</div>
		<div class="col-sm-4">
			<img src="/images/kredit/5.jpg">
			<h3>Защита бюджета</h3>
			<p style="color: #000; ">
				Комплексная программа страхования покупателей при покупке автомобиля марки Renault с использованием кредитных программ Renault Finance. 
			</p>
			<div class="" style="display: none;color: #555;">
				<p>
					Порядок и размер страховых выплат определяются в соответствии с Правилами добровольного страхования от несчастных случаев и болезней от 28 февраля 2014 года (в новой редакции - от 23 июня 2014 года).
				</p>
				<p>
					Подробную информацию об условиях страхования можно получить у специалистов по финансовым услугам автосалона.
				</p>
				<p>
					Услуги страхования предоставляет ООО «СК КАРДИФ» (лицензия на осуществление страхования СЛ № 4104 от 06.11.2015 выдана ЦБ РФ (бессрочно).
				</p>
			</div>
			<a class="viewkredit">Узнать больше</a>
		</div>
		<div class="col-sm-4">
			<img src="/images/kredit/6.jpg">
			<h3>Продленная гарантия</h3>
			<p style="color: #000; ">
				Сервисная программа продления базового срока гарантийного обслуживания приобретаемого автомобиля марки Renault.
			</p>
			<div class="" style="display: none; color: #555;">
				<p>
					Программа позволяет в период постгарантийного обслуживания автомобиля осуществлять его ремонт в официальных дилерских центрах Renault в соответствии с условиями заключенного сервисного контракта. При возникновении технических неисправностей, указанных в сервисном контракте, в период действия программы Вам будет достаточно обратиться в официальный дилерский центр Renault на территории РФ для проведения бесплатного сервисного обслуживания. Программа также включает в себя помощь на дорогах Renault Assistance.
				</p>
				<p>
					Подробную информацию о тарифах и условиях сервисного контракта Renault Extra Вы можете получить у специалистов по финансовым услугам автосалона или сотрудников сервисного центра.
				</p>
			</div>
			<a class="viewkredit">Узнать больше</a>
		</div>
	</div>
</div>

<!--ФОРМЫ-->
<?php if(is_array($data['form'])) : ?>
<div class="container-fluid" style="  " id="animate-block">
	<div class="container">
		<div class="block-title">
			ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
		</div>
		<div class="col-sm-12 text-center" style="font-size: 20px;">
			Мы рады, что Вас заинтересовали автомобили Renault. Дополнительную информацию Вы можете получить по телефону отдела продаж 8 (8212) 288 588 или задайте вопрос в форме ниже. Наши сотрудники свяжутся с Вами и постараются ответить на все вопросы.
		</div>

		<div class="col-sm-8 col-sm-offset-2" >
			<?php foreach ($form as $key => $form) : ?>
				<div class="">
					<?=$form->html;?>
					<input type="hidden" form="fcb<?=$form->id;?>" value="Страница кредитов" name="page" >
				</div>
			<?php endforeach;?>
		</div>
	</div>
</div>
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->

<form action="/content/availablelist" method="POST" style="display:none" id="availablecar">
	<input type="text" name="model" id="model">
	<input type="submit" name="submit" id="submit">
</form>

<script>
	$(document).ready(function(){
		
		$(".model-link").click(function(){
			var id = $(this).attr("data-id");
			$("#availablecar #model").val(id);
			$("#availablecar #submit").click();
		});

		$(".viewkredit").click(function(){
			if($(this).text()=='Закрыть')
			{
				$(this).parent().find('div').css("display","none");
				$(this).text("Узнать больше");
			}
			else
			{
				$(this).parent().find('div').css("display","block");
				$(this).text("Закрыть");
			}
		})

		$("form ").find("h2").css("display","none");
	})
</script>


<script>
	$(document).ready(function(){
		$(".ava-cars").click(function(){
			var id = $(this).attr("data-tab-car");
			$("#form-tab-car input").val(id);
			$("#form-tab-car").submit();
		})
	})
</script>

<form action="/available/viewlist" method="POST" id='form-tab-car'>
	<input type="hidden" value="" name="model">
</form>