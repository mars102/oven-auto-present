<?php
namespace app\models;
class Rmenu_model extends \app\core\Model
{
	
	public $table = "r_menu";

	public static function viewMenu($html=NULL)
	{
		$menu = new Rmenu_model();
		$data = $menu->getAll();

		if(!empty($data)) :
			$html = '<ul class="cbp-vimenu hidden-xs">';
				foreach($data as $obj) :

				$html .= '<li>';
					$html .= '<a href="'.$obj->link.'" class="icon-logo">';
	          			$html .= '<div class="row">';
			              	$html .= '<div class="col-sm-3">';
			                  	$html .= $obj->icon;
			              	$html .=  '</div>';
			              	$html .=  '<div class="col-sm-9 text-left">';
			                  	$html .= '<span>'.$obj->name.'</span>';
			              	$html .= '</div>';
	            		$html .= '</div>';
	        		$html .= '</a>';
	      		$html .= '</li>';
				endforeach;

				

			$html .= '</ul>';
		endif;
		return $html;
	}

}


      