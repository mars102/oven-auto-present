
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
					<div class="col-sm-9" style="padding-left: 30px;">
						<i class="news-date"><?= $item->getDateIn();?></i>
						<h3 class="news-title">
							<?= $item->title; ?>
						</h3>
						<p class="news-parag">
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
<div class="container-fluid " style="" id="animate-block">
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