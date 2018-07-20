<style type="text/css">
	.container img {max-width: 100%;height: auto;}
	.title-news{font-size: 30px; padding: 20px 0; font-family: 'Renault';}
	.block-news{font-size: 16px; color: #000;}
	/*.block-news img{width: 100% !important;}*/
	.news-main-pic{float: left; width: 300px;}
	/*@media screen and (max-width: 600px) {
		table {width:100%;}
		thead {display: none;}
		tr:nth-of-type(2n) {background-color: inherit;}
		tr td:first-child {background: #f0f0f0; font-weight:bold;font-size:1.3em;}
		tr th:first-child {font-weight:bold;font-size:1.3em;}
		tbody td, tbody th {display: block; text-align:center;}
		tbody td, tbody th:before {
		content: attr(data-th);
		display: block;
		text-align:center;
		}
	}*/
	@media screen and (max-width: 700px) {
		.news-min *{text-align: justify;}
		.news-min img{width: 100% !important;}
	}

	@media screen and (max-width: 600px) {

		.table {width:100% !important;}
		thead {display: none;}
		tr:nth-of-type(2n) {background-color: inherit;}
		tr td:first-child {background: #f0f0f0; font-weight:bold;font-size:1.3em;}
		tr th:first-child {font-weight:bold;font-size:1.3em;}
		tbody td, tbody th {display: block !important; text-align:center;}
		tbody td, tbody th:before {
			content: attr(data-th);
			display: block !important;
			text-align:center;
		}
	}

</style>

<div class="container marbot">

		<div class="row">
			<div class="block-title ">
				<?=$title;?>
			</div>

			<?php 
				if($pages->id_menu==10) $style = "news-min";
				else $style = "";
			?>
			<div class="col-sm-12 block-news <?=$style;?>" style="">
				<!--div class="col-sm-12"-->
					<?= $pages->text;?>
				<!--/div-->
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
					<input type="hidden" form="fcb<?=$form->id;?>" value="Страница новости - <?=$pages->title;?>" name="page" >
				</div>
			<?php endforeach;?>
		</div>
	</div>
</div>
<?php endif;?>
<!--КОНЕЦ ФОРМЫ-->

<script>
	$("form h2").remove();

	$(document).ready(function(){
		if($("body").width()<1200)
		{
			$(".block-news").css('border','0px');
			$(".block-news *").css('border','0px');
		}
		if($("body").width()<700)
		{
			var parent = $(".news-min").html();
			parent = parent.replace(/table/g, 'div');
			parent = parent.replace(/tr/g, 'div');
			parent = parent.replace(/td/g, 'div');
			parent = parent.replace(/style/g, 's');
			$(".block-news").html(parent);
		}
		$(".block-news img").each(function(index, value) { 
			$(this).attr("src","http://admin.oven-auto.ru"+$(this).attr("src"));
		});
	})
</script>


<!--link href="/lib/table/stacktable.css" rel="stylesheet" />


<script src="/lib/table/stacktable.js" type="text/javascript"></script>

<script>
	$('.table').addClass("stacktable");
	$('.table').addClass("large-only");
  	$('.table').stacktable();
</script>

<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-2821890-9']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script-->