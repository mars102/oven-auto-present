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

<script>
	$("form h2").remove();
	$(".block-news img").each(function(index, value) { 
		$(this).attr("src","http://admin.oven-auto.ru"+$(this).attr("src"));
	});
</script>