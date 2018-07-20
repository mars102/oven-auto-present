<?php

namespace app\models;
Class banner extends \app\core\Model
{
	public $table = 'banner';

	public function getBannerView()
	{
		$brand = BRAND;
		$banners = $this->getCustomSQL("SELECT * FROM {$this->table} WHERE brand = {$brand}");
		//echo "SELECT * FROM {$this->table} WHERE brand = {$brand}";
		$data ='';
		$data .= '<div class="banner-main hidden-xs">';
			foreach ($banners as $key => $ban) {
				$data .= '<div class="car-slider" style="background-image: url(http://admin.oven-auto.ru'.$ban->img.'); ">';
					$data .= '<div class="banner-content text-center">';
					if($ban->title!="") :
						$data .= "<div class='banner-title'>";
						$data .= "<p>".$ban->title."</p>";
						$data .= '</div>';
					endif;
					if($ban->text!="") :
						$data .= "<div class='banner-text'>";
						$data .= "<p>".$ban->text."</p>";
						$data .= '</div>';
					endif;
					if($ban->link!="") :
						$data .= "<div class='banner-text'>";
						$data .= '<a class="btn button-main-page" href="'.$ban->link.'">Подробнее</a>';
						$data .= "</div>";
					endif;
					$data .= '</div>';
				$data .= '</div>';
			}
		$data .= '</div>';
		return $data;
	}

	public static function addSlider($array = array(), $data="",$active="",$code="")
	{	
		$data .= '<div id="carousel-example-generic" class="carousel avacarslider slide" data-ride="carousel">';
		$data .= '<div class="carousel-inner" role="listbox">';
		foreach ($array as $key => $ban) {
			if(isset($ban['color'])) {

				$masColo = explode(',',$ban['color']);

				if(count($masColo)==1) {
					if(isset($ban['color'])) $color = $ban['color'];
					if(isset($ban['code'])) $code = $ban['code'];
					if(isset($ban['metalic'])) $metalic = $ban['metalic'];
					if($key==0) $active="active";
						$data .= '<div class="text-center item '.$active.'">';
							$data .= '<span style="text-align:center;display:inline-block;margin:0 auto;">';
								$data .= '<img style="width:100%;background:'.$color.'" src="'.$ban['img'].'" alt="...">';
								$data .= '<div class="car-color-name ban-cap text-center" style="">'.$code.'<br/>'.$metalic.'</div>';
							$data .= '</span>';
						$data .= '</div>';
					$active="";
					$color="";
					$code="";
				}
				else
				{
					if(isset($ban['color'])) $color = $ban['color'];
					if(isset($ban['metalic'])) $metalic = $ban['metalic'];
					if($masColo[1]=='#fff') $img="http://admin.oven-auto.ru/content/cars/39/w.png";
					else $img="http://admin.oven-auto.ru/content/cars/39/b.png";

					if(isset($ban['code'])) $code = $ban['code'];
					if($key==0) $active="active";
						$data .= '<div class="text-center item '.$active.'">';
							$data .= '<span style="text-align:center;display:inline-block;margin:0 auto;">';
								$data .= '<img style="width:100%;background:'.$masColo[0].'" src="'.$img.'" alt="...">';
								$data .= '<div class="car-color-name ban-cap text-center" style="">'.$code.'<br/>'.$metalic.', двухцветная</div>';
							$data .= '</span>';
						$data .= '</div>';
					$active="";
					$color="";
					$code="";
				}

			}
			else 
			{
				if($ban['img']!="Не существует каталога") :
					$data .= '<div class="text-center item '.$active.'">';
						$data .= '<span style="text-align:center;display:inline-block;margin:0 auto;">';
							$data .= '<img style="width:100%;" src="'.$ban['img'].'" alt="...">';
						$data .= '</span>';
					$data .= '</div>';
				endif;
			}
		}
		$data.='</div>';
		$data.='
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    	<span class="sr-only">Previous</span>
			</a>';
		$data.='
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			</a>';
		$data .= '</div>';
		return $data;
	}

}
?>

