
<?php if(isset($news)) { ?>
<?php if($news!=false) { ?>
<div class="container  news-on-main" style="padding-bottom: 20px;">
	<div class="col-sm-12">
		<div class="block-title"><?=$title;?></div>
	</div>

	<div class="col-sm-12 news-main">
		<?php foreach ($news as $key => $item) { ?>
			<div class="col-sm-6 news-block">
				<a class="news_link" href="/content/viewnew/<?= $item->id;?>">
				<div class="row">
					<div class="col-sm-3 news-img-block" style="">
						<?php $perem =$item->main_pic; if(!empty($perem)) $file = $item->main_pic;
							else $file = "/images/logonews.png";?>
						<img src="http://admin.oven-auto.ru<?=$file;?>" style="">
					</div>
					<div class="col-sm-9 news-content" style="">
						<i class="news-date"><?= $item->getDateIn();?></i>
						<h3 class="news-title">
							<?= $item->title; ?>
						</h3>
						<p class="news-parag hidden-xs">
							<?php 
							if($item->summary!="") :
								echo mb_substr(strip_tags($item->summary),0,100,"UTF-8").'...';
							
							else :
								echo mb_substr(strip_tags($item->text),0,100,"UTF-8").'...';
							endif;
							?>
						</p>
					</div>
					<!--div class="col-sm-12 text-right news-link"><a href="/content/viewnew/<?= $item->id;?>">Подробнее</a></div-->
				</div>
				</a>
			</div>
		<?php } ?>
	</div>

	<div class="row text-center">
		<?= $data['pagination']->getPagButtons();?>
	</div>

</div>
<?php } ?>
<?php } ?>


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
	<div class="container" id="question">
		<div class="block-title">
			ЕСТЬ ВОПРОСЫ? МЫ ОТВЕТИМ!
		</div>

		<div class="col-sm-8 col-sm-offset-2" >
			<?php foreach ($data['form'] as $key => $form) : ?>
				<div class="">
					<?=$form->html;?>
					<input type="hidden" form="fcb<?=$form->id;?>" value="Страница новости - <?=$new->title;?>" name="page" >
				</div>
			<?php endforeach;?>
		</div>
	</div>
</div>
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->