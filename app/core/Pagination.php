<?php
namespace app\core;
Class Pagination{
	public $button = array();
	public $currentInClass;
	public function __construct($count,$amount,$current){

		$all_page = ceil($count/$amount);
        //echo $current;
		/*if($current<0){
			$current = 1;
		}
		/*if ($all_page == 1) {
            return;
        }*/
        if ($current > $all_page) {
            $current = $all_page;
        }
        $url = explode('/',$_SERVER['REQUEST_URI']);
        $link = $url[1].'/'.$url[2];

        $min = 1;
        $max = $all_page;

        $pagePrev = $current-1;
        if(($current-1)<$min) $pagePrev = $min;

        $pageNext = ($current+1);
        if(($current+1)>$max) $pageNext = $max;

		$this->button['prev']['link'] = $link.'/'.$pagePrev;
		$this->button['prev']['page'] = $pagePrev;
        $this->button['prev']['class'] = " prev-pag";
        $this->button['prev']['name'] = 'назад';

        for ($i=0; $i<$all_page; $i++) {
        	$class = '';
        	if(($i+1)==$current){
        		$class = " current ";
        	}
			$this->button[$i+1]['link'] = $link.'/'.($i+1);
			$this->button[$i+1]['page'] = ($i+1);
        	$this->button[$i+1]['class'] = $class;
        	$this->button[$i+1]['name'] = $i+1;
        }

		$this->button['next']['link'] = $link.'/'.$pageNext;
		$this->button['next']['page'] = $pageNext;
        $this->button['next']['class'] = " prev-pag";
        $this->button['next']['name'] = 'вперёд';

        $this->currentInClass = $current;
	}

	public function getPagButtons(){
		if(count($this->button)>0) {
			$str = "<ul class='pagination'>";
			foreach ($this->button as $key => $item) {
				$str.="<li><a style='padding: 5px 10px;' data-page='".$item['page']."' class='".$item['class']."' href='/".$item['link']."'>".$item['name']."</a></li>";
			}
			$str .= "</ul>";
			return $str;
		}
		return false;
	}
}