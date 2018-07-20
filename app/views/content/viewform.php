<style type="text/css">
	.container img {max-width: 100%;height: auto;}
	form{padding-bottom:0px !important;}
	/*.title-news{font-size: 30px; padding: 20px 0; font-family: 'Renault';}
	.block-news{font-size: 16px; color: #000;}
	.news-main-pic{float: left; width: 300px;}*/
</style>

<!--div class="container-fluid "-->
	<div class="container" style="padding-bottom: 10px;">
		<div class="row">
			<div class="block-title"><?= $data['form']->head;?></div>
			<div class='col-sm-12 text-center' style='padding-bottom: 0px;font-size:20px;'><?= $data['form']->text;?></div>
			<div class="col-sm-8 col-sm-offset-2 ">
				<?= $data['form']->html;?>
				<input type="hidden" form="fcb<?=$data['form']->id;?>" value="Формы ОС (боковая панель) " name="page" >
			</div>
		</div>
	</div>
<!--/div-->
<script>
	$("form h2").remove();
</script>
