<style type="text/css">
	.container img {max-width: 100%;height: auto;}
	.title-news{font-size: 30px; padding: 20px 0; font-family: 'Renault';}
	.block-news{font-size: 16px; color: #000;}
	.news-main-pic{float: left; width: 300px;}
</style>

<div class="container-fluid banner-main ">
	<?php if(!empty($new->banner)) :?>
		<img src="http://admin.oven-auto.ru<?= $new->banner; ?>">
	<?php endif;?>
</div>
<div class="container block">

	<div class="row">
		<div class="col-sm-12">
			<i><?=$new->getDateIn();?></i>
		</div>
		<div class="col-sm-12 title-news text-left">
			<?=$new->title;?>
		</div>

		<div class="col-sm-12  block-news">
			<div class=" news-parag">
				<?= $new->text;?>
			</div>
		</div>

		<!--div class="col-sm-8 col-sm-offset-2" style="padding-top: 40px;">
			<?php if($form) : ?>
				<?php // $form;?>
				<input type="hidden" form="fcb<?=$new->form;?>" value="Новость - <?=$new->title;?>" name="page" >
			<?php endif;?>
		</div-->

		<div class="col-sm-4 col-sm-offset-8 text-right">
			<div class="">
				<a class="button button-yellow" href="<?= $_SERVER['HTTP_REFERER'];?>">Вернуться назад<i class="fa fa-angle-left"></i></a>
			</div>
		</div>
	</div>
</div>

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

<script>
	$("form h2").remove();
	$(".block-news img").each(function(index, value) { 
		$(this).attr("src","http://admin.oven-auto.ru"+$(this).attr("src"));
	});
</script>