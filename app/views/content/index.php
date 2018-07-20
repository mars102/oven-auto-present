<?php
	echo $banner->getBannerView();
?>
<?php if(is_array($models)) : ?>
	<div class="container black-bg hidden-xs" >
		<div class="container">
			<div class="row">
				<div id="tabs" class="text-center">
					<div class="col-sm-3"><a title="tab1" href="#">Все <br/>модели</a></div>
					<div class="col-sm-3"><a title="tab2" href="#">Легковые<br/>автомобили</a></div>
					<div class="col-sm-3"><a title="tab3" href="#">Кроссоверы <br/>и внедорожники</a></div>
					<div class="col-sm-3"><a title="tab4" href="#">Коммерческие <br/>автомобили</a></div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row text-center">
			<div id="content">
				<div id="tab1" class="tab-block">
					<div class="col-sm-12 ">
						<?php foreach ($models as $model) : ?>
							<?php $model->getModelForTab();?>
						<?php endforeach; ?>
					</div>
				</div>
				<div id="tab2" class="tab-block">
					<?php foreach ($models as $model) : ?>
						<?php if($model->type==1) : ?>
							<?php $model->getModelForTab();?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<div id="tab3" class="tab-block">
					<?php foreach ($models as $model) : ?>
						<?php if($model->type==2) : ?>
							<?php $model->getModelForTab();?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<div id="tab4" class="tab-block">
					<?php foreach ($models as $model) : ?>
						<?php if($model->type==3) : ?>
							<?php $model->getModelForTab();?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="container-fluid" style="background: #fff;border-top: 2px solid #fc3;padding-bottom:30px;">
	<?php if(is_array($actions)) : ?>
		<div class="container">
			<div class="text-center block-title">Акции и специальные предложения</div>
			<div class="row text-center">
				<div class="action-area">
					<?php foreach($actions as $action) : ?>
						<div class="action-slide">
							<img src="http://admin.oven-auto.ru<?=$action->main_pic;?>">
							<div style="padding: 10px 0;" class="action-name name text-left"><?=$action->title;?></div>
							<div class="text-left">
								<a class="button button-yellow" href="/content/viewnew/<?=$action->id;?>">Подробнее<i class="fa fa-angle-right"></i></a>
							</div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	<?php endif;?>
</div>

<?php if(is_array($news)) : ?>
	<div class="container news-on-main hidden-xs">
		<div class="col-sm-12 ">
			<div class="text-center block-title">Новости Renault.Овен-Авто</div>
		</div>

		<div class="col-sm-row news-main">
			<?php foreach ($news as $key => $new) : ?>
				<div class="col-sm-6 news-block">
					<a class="news_link" href="/content/viewnew/<?= $new->id;?>">
						<div class="row">
							<div class="col-sm-3  news-img-block">
								<img src="http://admin.oven-auto.ru<?=$new->getMainPic();?>">
							</div>
							<div class="col-sm-9 " style="padding-left: 30px;padding-top: 10px;">
								<i class="news-date"><?= $new->getBeginDate();?></i>
								<h3 class="news-title">
									<?= $new->title; ?>
								</h3>
								<p class="news-parag hidden-xs text-left" style="line-height: 15px;">
									<?php 
									if($new->summary!="") :
										echo mb_substr(strip_tags($new->summary),0,60,'UTF-8').'...';
									
									else :
										echo mb_substr(strip_tags($new->text),0,60,'UTF-8').'...';
									endif;
									?>
								</p>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
			<div class="col-sm-6 news-block">
				<a class="text-center news_link" href="/content/newslist" style="border:1px solid #e5e5e5; background: #fc3;">
					<span class="see-all-news">Просмотреть все новости <i class="fa fa-angle-right" style="display:inline-block;font-size: 15px;padding-left: 7px;" aria-hidden="true"></i></span>

				</a>
			</div>
		</div>
	</div>
<?php endif;?>

<div class=" container-fluid hidden-xs " style="background: #fefefe;padding-bottom:20px;">
	<div class="container" style="border-radius: 20px; color: #333;">
		<div class="row">

			<div class="col-sm-12 hidden-xs" style="padding-top:20px;">
				<img src="/images/showroom.jpg" style="width:100%;"/>
			</div>

			<div class="col-sm-12 text-center">
				<h3 class=" text-left">Автосалон Овен-Авто. Официальный дилер Renault в г. Сыктывкаре, Республика Коми</h3>
			</div>
			
			<div class="col-sm-3">

					<span class="contact-title">Адрес</span>
					<div class="contact-param">г. Сыктывкар ул. <div class="forbr"></div>Гаражная 1</div>
					<span class="contact-title">Телефон</span>
					<div style="padding-bottom: 12px;" class="contact-param"><a href="tel:88212288588"> 8 (8212) 288-588</a></div>
					<a class="button button-yellow" href="http://test.myhost/content/viewpage/26/contactinfo">Все контакты<i class="fa fa-angle-right"></i></a>

			</div>

			<div class="col-sm-9 hidden-xs">
				<p class="news-parag text-justify">
					Овен-Авто – единственный официальный дилер марки Renault в Республике Коми. 
					Приглашаем Вас посетить наш автосалон и познакомиться с новыми автомобилями Renault. Шоурум дилерского центра отвечает высоким стандартам производителя и порадует Вас незабываемой атмосферой мира Renault, а наши специалисты постараются сделать все, чтобы оправдать Ваши ожидания. К Вашим услугам парк подменных автомобилей и автомобили для пробной поездки, финансовые и страховые консультации, сервисный центр, оснащенный современным оборудованием, МКП, автомойка и многое другое…<br/>
					Добро пожаловать в мир Renault.
				</p>
			</div>
		</div>
	</div>	
</div>

<script>
	$(document).ready(function(){
		$(".count-car").click(function(){
			var id = $(this).attr("data-tab-car");
			$("#form-tab-car input").val(id);
			$("#form-tab-car").submit();
		})
	})
</script>

<form action="/content/availablelist" method="POST" id='form-tab-car'>
	<input type="hidden" value="" name="model">
</form>

<div class="container-fluid maps hidden-xs" style="border-top:solid 2px #fc3;">
	<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=iBDoe_EVCxr-qwJmTX-2cG__TkKSkWJf&width=auto&height=350"></script>
</div>