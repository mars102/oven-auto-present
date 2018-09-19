<?php
namespace app\models;
Class car_docs extends \app\core\Model{
	public $table = 'car_docs';

	public function getDocByName($name)
	{
		return DOMEN."/".$this->$name;
	}

	public function getDocBlock()
	{
	?>
		<div class="container  document-car block" style="padding-bottom: 0px;">
			<div class="col-sm-12 " id="doki">
			<?php if(!empty($this->brochure)) : ?>
				<div class="col-sm-2  col-sm-xs-offset-0 col-xs-6 text-center" id="regulator">
					<a target="_bank" class="document-block" href="http://admin.oven-auto.ru<?= $this->brochure;?>" >
							<img src="/images/icons/b.jpg">
						</a>
						<a target="_bank" class="document-block item-file" href="http://admin.oven-auto.ru<?= $this->brochure;?>" >
							<span class="sub-title">Брошюра</span>
						</a>
					</div>
			<?php endif;?>


				
				<?php if(!empty($this->price)) : ?>
					<div class="col-sm-2 col-xs-6 text-center tor">
						<a target="_bank" class="document-block" href="http://admin.oven-auto.ru<?= $this->price;?>" >
							<img src="/images/icons/p.jpg">
						</a>
						<a target="_bank" class="document-block item-file" href="http://admin.oven-auto.ru<?= $this->price;?>" >
							<span class="sub-title">Прайс-лист</span>
						</a>
					</div>
				<?php endif;?>
				
				<?php if(!empty($this->manual)) : ?>

				<div class="col-sm-2  col-xs-6 text-center tor">
					<a style="" target="_bank" class="document-block" href="http://admin.oven-auto.ru<?= $this->manual;?>" >
							<img src="/images/icons/m.jpg">
						</a>
						<a  style="" target="_bank" class="document-block item-file" href="http://admin.oven-auto.ru<?= $this->manual;?>" >
							<span class="sub-title">Инструкции</span>
						</a>
					  	
				</div>
				<?php endif;?>
				<?php if(!empty($this->toys)) : ?>
					<div class="col-sm-2 col-xs-6 text-center tor">
					
					
						<a target="_bank" class="document-block" href="http://admin.oven-auto.ru<?= $this->toys;?>" >
							<img src="/images/icons/c.jpg">
						</a>
						<a target="_bank" class="document-block item-file" href="http://admin.oven-auto.ru<?= $this->toys;?>" >
							<span class="sub-title">Аксессуары</span>
						</a>
					</div>
				<?php endif;?>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			console.log();
			var dok = document.getElementById('doki')

			if (dok.children.length==4){

				doki.firstElementChild.className="col-sm-offset-2 col-sm-2  col-sm-xs-offset-0 col-xs-6 text-center";

			} else if(document.getElementById('doki').children.length==3){

				doki.firstElementChild.className="col-sm-offset-3 col-sm-2  col-sm-xs-offset-0 col-xs-6 text-center";

			} else if(document.getElementById('doki').children.length==2){

				doki.firstElementChild.className="col-sm-offset-4 col-sm-2  col-sm-xs-offset-0 col-xs-6 text-center";

			}

		});
		</script>>
	<?php
	}
}